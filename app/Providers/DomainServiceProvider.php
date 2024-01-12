<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Auth\Providers\ShopAuthServiceProvider;
use Domain\Catalog\Providers\CatalogServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ShopAuthServiceProvider::class);

        $this->app->register(CatalogServiceProvider::class);
    }
}
