<?php

namespace App\Providers;

use Domain\Catalog\Sorters\Sorter;
use Support\Filters\FilterManager;
use Domain\Catalog\Filters\BrandFilter;
use Domain\Catalog\Filters\PriceFilter;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        app(FilterManager::class)->registerItems([
            new PriceFilter,
            new BrandFilter,
        ]);

        $this->app->bind(Sorter::class, function () {
            return new Sorter([
                'title',
                'price',
            ]);
        });
    }
}
