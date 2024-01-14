<?php

namespace App\Providers;

use Domain\Auth\Providers\ShopAuthServiceProvider;
use Domain\Catalog\Providers\CatalogServiceProvider;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ShopAuthServiceProvider::class);

        $this->app->register(CatalogServiceProvider::class);
    }
}
