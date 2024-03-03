<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductStockRepositoryInterface;
use App\Models\ProductStock;
use Exception;

class ProductStockRepository implements ProductStockRepositoryInterface
{
    /**
     * @var ProductStock
     */
    private $productStock;

    /**
     * ProductStockRepository constructor.
     *
     * @param ProductStock $productStock
     */
    public function __construct(ProductStock $productStock)
    {
        $this->productStock = $productStock;
    }

    /**
     * Crie um novo estoque do produto com os dados fornecidos.
     *
     * @param array $data
     * @return ProductStock
     */
    public function create(array $data): ProductStock
    {
        return $this->productStock->create($data);
    }

    /**
     * Verifique se um produto está disponível em estoque.
     *
     * @param int $productId
     * @return bool
     */
    public function isProductAvailable(int $productId): bool
    {
        $stock = $this->productStock->where('product_id', $productId)->first();
        return $stock && $stock->amount > 0;
    }

    /**
     * Obtém a quantidade disponível em estoque para um produto específico.
     *
     * @param int $productId
     * @return int
     */
    public function getStockByProductId(int $productId): int
    {
        $stock = $this->productStock->where('product_id', $productId)->first();
        return $stock ? $stock->amount : 0;
    }

    /**
     * Verifica se a quantidade do produto está disponível no estoque.
     *
     * @param int $productId
     * @param int $amount
     * @return bool
     */
    public function hasSufficientStock(int $productId, int $amount): bool
    {
        $stock = $this->productStock->where('product_id', $productId)->first();
        return $stock && $stock->amount >= $amount;
    }

    /**
     * Diminui a quantidade de estoque para um produto específico.
     *
     * @param int $productId
     * @param int $amount
     * @return bool
     */
    public function decreaseStock(int $productId, int $amount): bool
    {
        $stock = $this->productStock->where('product_id', $productId)->firstOrFail();
        $stock->amount -= $amount;
        return $stock->save();
    }

    /**
     * Aumenta o estoque de um produto pelo seu ID.
     *
     * @param int $productId
     * @param int $amount
     * @return bool
     * @throws Exception
     */
    public function increaseStock(int $productId, int $amount): bool
    {
        $stock = $this->productStock->where('product_id', $productId)->first();

        if (!$stock) {
            throw new Exception("Estoque para o produto com ID $productId não encontrado.");
        }

        $stock->amount += $amount;

        return $stock->save();
    }
}
