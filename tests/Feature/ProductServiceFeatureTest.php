<?php

namespace Tests\Feature\Services;

use Tests\TestCase;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductStockRepositoryInterface;

class ProductServiceFeatureTest extends TestCase
{
    public function test_get_active_products()
    {
        $this->mock(ProductRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('getAllActiveProducts')->andReturn(new \Illuminate\Database\Eloquent\Collection([
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
        });

        $this->mock(ProductStockRepositoryInterface::class, function ($mock) {
            $mock->shouldReceive('isProductAvailable')->andReturn(true);
            $mock->shouldReceive('getStockByProductId')->andReturn(10);
        });

        $response = $this->get('/api/products');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Listagem realizada com sucesso.',
                'data' => [
                    ['name' => 'Product 1', 'stock_quantity' => 10],
                ]
            ]);
    }
}
