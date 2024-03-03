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

    /**
     * Verifique se um produto está ativo.
     *
     * @param int $productId
     * @return bool
     */
    public function isActive(int $productId): bool;

    /**
     * Verifique se um produto existe.
     *
     * @param int $productId
     * @return bool
     */
    public function exists(int $productId): bool;

    /**
     * Busca um produto pelo seu ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product;

    /**
     * Retorna o preço do produto com o ID fornecido.
     *
     * @param int $productId
     * @return int
     */
    public function getProductPrice(int $productId): int;
}
