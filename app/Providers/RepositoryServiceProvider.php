<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;

use App\Repositories\Interfaces\ProductStockRepositoryInterface;
use App\Repositories\ProductStockRepository;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use App\Repositories\SaleRepository;

use App\Repositories\Interfaces\SaleProductRepositoryInterface;
use App\Repositories\SaleProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductStockRepositoryInterface::class, ProductStockRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(SaleProductRepositoryInterface::class, SaleProductRepository::class);
    }
}
