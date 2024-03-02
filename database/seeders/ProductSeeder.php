<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductStockRepositoryInterface;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(
        ProductRepositoryInterface $productRepository,
        ProductStockRepositoryInterface $productStockRepository
    ) {
        $products = [
            [
                'name' => 'Celular 1',
                'price' => 1800,
                'description' => 'Lorenzo Ipsulum',
                'active' => true
            ],
            [
                'name' => 'Celular 2',
                "price" => 3200,
                "description" => 'Lorem ipsum dolor',
                'active' => true
            ],
            [
                'name' => 'Celular 3',
                'price' => 9800,
                'description' => 'Lorem ipsum dolor sit amet',
                'active' => true
            ]
        ];

        foreach ($products as $productData) {
            $product = $productRepository->create($productData);

            $productStockRepository->create([
                'product_id' => $product->id,
                'amount' => 10
            ]);
        }
    }
}
