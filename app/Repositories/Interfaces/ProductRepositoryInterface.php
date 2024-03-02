<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    /**
     * Crie um novo produto com os dados fornecidos.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * Obtenha todos os produtos ativos.
     *
     * @return Collection
     */
    public function getAllActiveProducts(): Collection;
}
