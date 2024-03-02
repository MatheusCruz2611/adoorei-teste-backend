<?php

namespace App\Repositories\Interfaces;

use App\Models\ProductStock;

interface ProductStockRepositoryInterface
{
    /**
     * Crie um novo estoque do produto com os dados fornecidos.
     *
     * @param array $data
     * @return ProductStock
     */
    public function create(array $data): ProductStock;

    /**
     * Verifique se um produto está disponível em estoque.
     *
     * @param int $productId
     * @return bool
     */
    public function isProductAvailable(int $productId): bool;

    /**
     * Obtém a quantidade disponível em estoque para um produto específico.
     *
     * @param int $productId
     * @return int
     */
    public function getStockByProductId(int $productId): int;
}
