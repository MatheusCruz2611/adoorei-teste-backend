<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductStockRepositoryInterface;

use App\Models\ProductStock;

class ProductStockRepository implements ProductStockRepositoryInterface
{
    /**
     * @var ProductStock
     */
    private $productStock;

    /**
     * ProductStockRepository constructor.
     *
     * @param ProductStock $productStock
     */
    public function __construct(ProductStock $productStock)
    {
        $this->productStock = $productStock;
    }

    /**
     * Crie um novo estoque do produto com os dados fornecidos.
     *
     * @param array $data
     * @return ProductStock
     */
    public function create(array $data): ProductStock
    {
        return $this->productStock->create($data);
    }

    /**
     * Verifique se um produto está disponível em estoque.
     *
     * @param int $productId
     * @return bool
     */
    public function isProductAvailable(int $productId): bool
    {
        $stock = $this->productStock->where('product_id', $productId)->first();
        return $stock && $stock->amount > 0;
    }

    /**
     * Obtém a quantidade disponível em estoque para um produto específico.
     *
     * @param int $productId
     * @return int
     */
    public function getStockByProductId(int $productId): int
    {
        $stock = $this->productStock->where('product_id', $productId)->first();
        return $stock ? $stock->amount : 0;
    }
}