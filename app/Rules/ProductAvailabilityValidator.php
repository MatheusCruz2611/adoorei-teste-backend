<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductStockRepositoryInterface;

class ProductAvailabilityValidator implements Rule
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ProductStockRepositoryInterface
     */
    private $productStockRepository;

    /**
     * Crie uma nova instância de regra.
     *
     * @return void
     */
    public function __construct()
    {
        $this->productRepository = app(ProductRepositoryInterface::class);
        $this->productStockRepository = app(ProductStockRepositoryInterface::class);
    }

    /**
     * Determine se a regra de validação foi aprovada.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $product = $this->productRepository->find($value);
        if (!$product || !$product->active) {
            return false;
        }
        $stock = $this->productStockRepository->isProductAvailable($value);
        return $stock;
    }

    /**
     * Receba a mensagem de erro de validação.
     *
     * @return string
     */
    public function message()
    {
        return 'O produto não está ativo, não existe ou não tem estoque disponível.';
    }
}
