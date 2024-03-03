<?php

namespace App\Repositories\Interfaces;

use App\Models\Sale;

interface SaleRepositoryInterface
{
    /**
     * Crie uma nova venda com os dados fornecidos.
     *
     * @param array $data
     * @return Sale
     */
    public function create(array $data): Sale;
}
