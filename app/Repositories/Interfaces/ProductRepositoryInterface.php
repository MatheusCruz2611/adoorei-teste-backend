<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * Crie um novo produto com os dados fornecidos.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product;
}
