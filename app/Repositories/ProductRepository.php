<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Obtenha todos os produtos ativos.
     *
     * @return Collection
     */
    public function getAllActiveProducts(): Collection
    {
        return $this->product->where('active', true)->get();
    }

    /**
     * Verifique se um produto está ativo.
     *
     * @param int $productId
     * @return bool
     */
    public function isActive(int $productId): bool
    {
        $product = $this->product->find($productId);
        return $product ? $product->active : false;
    }

    /**
     * Verifique se um produto existe.
     *
     * @param int $productId
     * @return bool
     */
    public function exists(int $productId): bool
    {
        return $this->product->where('id', $productId)->exists();
    }

    /**
     * Busca um produto pelo seu ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product
    {
        return $this->product->find($id);
    }

    /**
     * Retorna o preço do produto com o ID fornecido.
     *
     * @param int $productId
     * @return int
     */
    public function getProductPrice(int $productId): int
    {
        $product = $this->product->find($productId);
        if ($product) {
            return $product->price;
        } else {
            return 0;
        }
    }
}
