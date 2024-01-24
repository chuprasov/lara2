<?php

namespace App\Providers;

use Domain\Auth\Providers\ShopAuthServiceProvider;
use Domain\Cart\Providers\CartServiceProvider;
use Domain\Catalog\Providers\CatalogServiceProvider;
use Domain\Product\Providers\ProductServiceProvider;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ShopAuthServiceProvider::class);

        $this->app->register(CatalogServiceProvider::class);

        $this->app->register(ProductServiceProvider::class);

        $this->app->register(CartServiceProvider::class);
    }
}
