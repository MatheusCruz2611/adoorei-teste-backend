<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductStockRepositoryInterface;

class ProductServiceTest extends TestCase
{
    public function test_get_active_products()
    {
        $productRepoMock = $this->getMockBuilder(ProductRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $productStockRepoMock = $this->getMockBuilder(ProductStockRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $productRepoMock->method('getAllActiveProducts')->willReturn(new \Illuminate\Database\Eloquent\Collection([
            (object) [
                'id' => 1,
                'name' => 'Product 1',
                'price' => 10.00,
                'description' => 'Description 1'
            ],
            (object) [
                'id' => 2,
                'name' => 'Product 2',
                'price' => 20.00,
                'description' => 'Description 2'
            ]
        ]));

        $productStockRepoMock->method('isProductAvailable')->willReturnCallback(function ($productId) {
            return $productId == 1 ? true : false;
        });

        $productStockRepoMock->method('getStockByProductId')->willReturn(10);

        $productService = new ProductService($productRepoMock, $productStockRepoMock);

        $result = $productService->getActiveProducts();

        $this->assertCount(1, $result);
        $this->assertEquals('Product 1', $result[0]['name']);
    }

    public function test_product_sufficient_stock()
    {
        $productRepoMock = $this->getMockBuilder(ProductRepositoryInterface::class)->getMock();
        $productStockRepoMock = $this->getMockBuilder(ProductStockRepositoryInterface::class)->getMock();

        $productStockRepoMock->method('hasSufficientStock')->willReturn(true);

        $productService = new ProductService($productRepoMock, $productStockRepoMock);

        $result = $productService->productSufficientStock(1, 5);

        $this->assertTrue($result);
    }
}
