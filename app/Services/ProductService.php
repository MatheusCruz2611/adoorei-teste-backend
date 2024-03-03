<?php

namespace App\Services;

use Exception;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductStockRepositoryInterface;

class ProductService
{
    protected $productRepository;
    protected $productStockRepository;

    /**
     * ProductService constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param ProductStockRepositoryInterface $productStockRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductStockRepositoryInterface $productStockRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productStockRepository = $productStockRepository;
    }

    /**
     * Obtenha todos os produtos ativos com estoque disponível.
     *
     * @return array
     * @throws Exception
     */
    public function getActiveProducts(): array
    {
        try {
            $products = $this->productRepository->getAllActiveProducts();

            $availableProducts = $products->filter(function ($product) {
                return $this->productStockRepository->isProductAvailable($product->id);
            })->map(function ($product) {
                try {
                    $amount = $this->productStockRepository->getStockByProductId($product->id);
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'stock_quantity' => $amount,
                        'description' => $product->description ?? '-'
                    ];
                } catch (Exception $e) {
                    throw new Exception('Falha ao obter estoque do produto.');
                }
            })->filter()->toArray();

            return $availableProducts;
        } catch (Exception $e) {
            throw new Exception('Falha ao recuperar produtos ativos.');
        }
    }

    /**
     * Verifica se há estoque suficiente para um produto.
     *
     * @param int $productId
     * @param int $amount
     * @return bool
     */
    public function productSufficientStock(int $productId, int $amount): bool
    {
        return $this->productStockRepository->hasSufficientStock($productId, $amount);
    }
}
