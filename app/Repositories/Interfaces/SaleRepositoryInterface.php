<?php

namespace App\Repositories\Interfaces;

use App\Models\Sale;
use Illuminate\Pagination\LengthAwarePaginator;

interface SaleRepositoryInterface
{
    /**
     * Crie uma nova venda com os dados fornecidos.
     *
     * @param array $data
     * @return Sale
     */
    public function create(array $data): Sale;

    /**
     * Lista todas as vendas com paginação.
     *
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 10, int $page = 1): LengthAwarePaginator;
}
