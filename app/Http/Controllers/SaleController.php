<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\SaleService;
use App\Rules\ProductAvailabilityValidator;
use Illuminate\Support\Facades\Validator;

/**
 * @group Sales
 * APIs para gerenciamento de vendas
 */
class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * Cria uma nova venda com os produtos fornecidos.
     *
     * @param array $products Matriz de IDs e quantidades de produtos.
     * @bodyParam products array required Matriz de IDs e quantidades de produtos. Exemplo: [{"product_id":1,"amount":2},{"product_id":2,"amount":3}]
     * @return array Um array contendo os detalhes da venda criada, incluindo o ID da venda, a quantidade total de produtos vendidos e detalhes de cada produto.
     * @throws
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
            'products' => 'required|array',
            'products.*.product_id' => ['required', 'integer', new ProductAvailabilityValidator],
            'products.*.amount' => ['required', 'integer']
        ];

        $messages = [
            'products.required' => 'O campo produtos é obrigatório e deve ser um array.',
            'products.*.product_id.required' => 'O product_id do produto é obrigatório.',
            'products.*.product_id.integer' => 'O product_id do produto deve ser um número inteiro.',
            'products.*.amount.required' => 'A quantidade do produto é obrigatória.',
            'products.*.amount.integer' => 'A quantidade do produto deve ser um número inteiro.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $products = $request->input('products');

        try {
            $sale = $this->saleService->createSale($products);
            return response()->json([
                'message' => 'Venda armazenada com sucesso.',
                'data' => $sale
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }
}
