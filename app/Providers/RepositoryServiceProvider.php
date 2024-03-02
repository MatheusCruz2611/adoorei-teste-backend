<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;

use App\Repositories\Interfaces\ProductStockRepositoryInterface;
use App\Repositories\ProductStockRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductStockRepositoryInterface::class, ProductStockRepository::class);
    }
}
