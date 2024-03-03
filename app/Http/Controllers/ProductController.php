<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Services\ProductService;

/**
 * @group Products
 * APIs para gerenciamento de produtos
 */
class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Liste todos os produtos ativos com estoque disponível.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $products = $this->productService->getActiveProducts();
            return response()->json([
                'message' => 'Listagem realizada com sucesso.',
                'data' => $products
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }
}
