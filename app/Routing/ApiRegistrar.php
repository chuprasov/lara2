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
                Route::get('/products/all', [ApiProductController::class, 'getAll'])->name('api.products.all');
                Route::get('/products/page/{cnt}', [ApiProductController::class, 'getPage'])->name('api.products.page');
                Route::get('/products/{product:id}', [ApiProductController::class, 'getOne'])->name('api.products.show');
            });
    }
}
