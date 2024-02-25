<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Domain\Catalog\Sorters\Sorter;
use Support\Filters\FilterManager;
use Domain\Catalog\Filters\BrandFilter;
use Domain\Catalog\Filters\PriceFilter;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

class ApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
            );
        });
    }
}
