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
     * @return JsonResponse Um array contendo os detalhes da venda criada, incluindo o ID da venda, a quantidade total de produtos vendidos e detalhes de cada produto.
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

    /**
     * Lista todas as vendas com paginação.
     *
     * @queryParam page Número da página para a paginação (padrão: 1). 
     * @queryParam per_page Número de itens por página (padrão: 10).
     * 
     * @response {
     *   "message": "Vendas listadas com sucesso.",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "sales_id": 1,
     *         "amount": 11600,
     *         "products": [
     *           {
     *             "product_id": 3,
     *             "amount": 1,
     *             "name": "Celular 3",
     *             "price": 9800
     *           },
     *           {
     *             "product_id": 1,
     *             "amount": 1,
     *             "name": "Celular 1",
     *             "price": 1800
     *           }
     *         ]
     *       },
     *       {
     *         "sales_id": 2,
     *         "amount": 9600,
     *         "products": [
     *           {
     *             "product_id": 2,
     *             "amount": 2,
     *             "name": "Celular 2",
     *             "price": 4800
     *           }
     *         ]
     *       }
     *     ],
     *     "first_page_url": "...",
     *     "from": 1,
     *     "last_page": 1,
     *     "last_page_url": "...",
     *     "next_page_url": null,
     *     "path": "...",
     *     "per_page": 10,
     *     "prev_page_url": null,
     *     "to": 2,
     *     "total": 2
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);

        try {
            $sales = $this->saleService->paginateSales($perPage, $page);
            return response()->json([
                'message' => 'Vendas listadas com sucesso.',
                'data' => $sales
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }

    /**
     * Lista os detalhes de uma única venda.
     *
     * @param int $saleId
     * @return JsonResponse
     */
    public function show(int $saleId): JsonResponse
    {
        try {
            $sale = $this->saleService->getSale($saleId);
            return response()->json([
                'message' => 'Venda listada com sucesso.',
                'data' => $sale
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }

    /**
     * Cancela uma venda específica.
     *
     * @param int $saleId
     * @return JsonResponse
     */
    public function cancel(int $saleId): JsonResponse
    {
        try {
            $this->saleService->cancelSale($saleId);
            return response()->json([
                'message' => 'Venda cancelada com sucesso.'
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }
}
