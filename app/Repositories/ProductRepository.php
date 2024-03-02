<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Product
     */
    private $product;

    /**
     * ProductRepository constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Crie um novo produto com os dados fornecidos.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product
    {
        return $this->product->create($data);
    }
}
