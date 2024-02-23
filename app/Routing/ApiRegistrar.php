<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Api\ApiProductController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class ApiRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('api')->prefix('api')
            ->group(function () {
                Route::get('/products', [ApiProductController::class, 'index'])->name('api.products');
                Route::get('/product/{product:id}', [ApiProductController::class, 'show'])->name('api.products.show');
            });
    }
}
