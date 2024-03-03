<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SaleRepository implements SaleRepositoryInterface
{
    /**
     * @var Sale
     */
    private $sale;

    /**
     * SaleRepository constructor.
     *
     * @param Sale $sale
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Crie uma nova venda com os dados fornecidos.
     *
     * @param array $data
     * @return Sale
     */
    public function create(array $data): Sale
    {
        return $this->sale->create($data);
    }

    /**
     * Lista todas as vendas com paginação.
     *
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 10, int $page = 1): LengthAwarePaginator
    {
        return $this->sale
            ->with('products')
            ->groupBy('sales.id')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Busca uma venda pelo seu ID.
     *
     * @param int $id
     * @return Sale|null
     */
    public function find(int $id): ?Sale
    {
        return $this->sale->find($id);
    }
}
