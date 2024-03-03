<?php

namespace App\Repositories;

use App\Models\SaleProduct;
use App\Repositories\Interfaces\SaleProductRepositoryInterface;

class SaleProductRepository implements SaleProductRepositoryInterface
{
    /**
     * @var SaleProduct
     */
    private $saleProduct;

    /**
     * SaleProductRepository constructor.
     *
     * @param SaleProduct $saleProduct
     */
    public function __construct(SaleProduct $saleProduct)
    {
        $this->saleProduct = $saleProduct;
    }

    /**
     * Armazenar os produtos de um venda.
     *
     * @param array $data
     * @return SaleProduct
     */
    public function create(array $data): SaleProduct
    {
        return $this->saleProduct->create($data);
    }
}
