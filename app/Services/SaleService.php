<?php

namespace App\Services;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use App\Repositories\Interfaces\ProductStockRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\SaleProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Enums\SaleStatus;

class SaleService
{
    protected $saleRepository;
    protected $productService;
    protected $productStockRepository;
    protected $productRepository;
    protected $saleProductRepository;

    /**
     * Construtor da classe SaleService
     * 
     * @param SaleRepositoryInterface $saleRepository
     * @param ProductService $productService
     * @param ProductStockRepositoryInterface $productStockRepository
     * @param ProductRepositoryInterface $productRepository
     * @param SaleProductRepositoryInterface $saleProductRepository
     */
    public function __construct(
        SaleRepositoryInterface $saleRepository,
        ProductService $productService,
        ProductStockRepositoryInterface $productStockRepository,
        ProductRepositoryInterface $productRepository,
        SaleProductRepositoryInterface $saleProductRepository
    ) {
        $this->saleRepository = $saleRepository;
        $this->productService = $productService;
        $this->productStockRepository = $productStockRepository;
        $this->productRepository = $productRepository;
        $this->saleProductRepository = $saleProductRepository;
    }

    /**
     * Cria uma nova venda com os produtos fornecidos.
     * 
     * @param array $products
     * @return array
     * @throws Exception
     */
    public function createSale(array $products): array
    {
        DB::beginTransaction();

        try {
            $totalProducts = count($products);
            $totalPrice = $this->getTotalPrice($products);
            $saleProducts = [];

            // Criação da venda
            $sale = $this->saleRepository->create([
                'status' => SaleStatus::Done,
                'total_products' => $totalProducts,
                'price' => $totalPrice
            ]);

            foreach ($products as $item) {
                $productId = $item['product_id'];
                $amount = $item['amount'];

                // Verificação do estoque do produto
                $this->checkProductStock($productId, $amount);

                // Busca informações do produto
                $product = $this->productRepository->find($productId);

                $saleProducts[] = [
                    'product_id' => $productId,
                    'amount' => $amount,
                    'name' => $product->name,
                    'price' => $product->price
                ];

                // Criação do registro de produto vendido
                $this->saleProductRepository->create([
                    'sale_id' => $sale->id,
                    'product_id' => $productId,
                    'amount' => $amount
                ]);

                // Reduz a quantidade em estoque do produto
                $this->productStockRepository->decreaseStock($productId, $amount);
            }

            DB::commit();

            return [
                'sales_id' => $sale->id,
                'amount' => $totalPrice,
                'products' => $saleProducts,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Verifica se há estoque suficiente para um produto.
     * 
     * @param int $productId 
     * @param int $amount
     * @return void
     * @throws Exception
     */
    private function checkProductStock(int $productId, int $amount): void
    {
        if (!$this->productService->productSufficientStock($productId, $amount)) {
            throw new Exception("Estoque insuficiente para o produto com ID $productId.", 422);
        }
    }

    /**
     * Calcula o preço total da compra.
     * 
     * @param array $products
     * @return int
     */
    private function getTotalPrice(array $products): int
    {
        $totalPrice = 0;

        foreach ($products as $item) {
            $productPrice = $this->productRepository->getProductPrice($item['product_id']);
            $totalPrice += $productPrice * $item['amount'];
        }

        return $totalPrice;
    }
}
