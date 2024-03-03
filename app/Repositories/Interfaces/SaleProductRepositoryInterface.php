<?php

namespace App\Repositories\Interfaces;

use App\Models\SaleProduct;

interface SaleProductRepositoryInterface
{
    /**
     * Armazenar os produtos de um venda.
     *
     * @param array $data
     * @return SaleProduct
     */
    public function create(array $data): SaleProduct;
}
