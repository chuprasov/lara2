<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiProductController;

class ApiRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('api')->prefix('api')
            ->group(function () {
                Route::get('/products/all', [ApiProductController::class, 'getAll'])
                    ->name('api.products.all');
                Route::get('/products/paginate/{cnt}', [ApiProductController::class, 'getPaginate'])
                    ->name('api.products.paginate')
                    ->middleware('auth:sanctum');
                Route::get('/products/{product:id}', [ApiProductController::class, 'getOne'])
                    ->name('api.products.show')
                    ->middleware('auth:sanctum');

                Route::post('register',[ApiAuthController::class,'register']);
                Route::post('login',[ApiAuthController::class,'login']);
                Route::delete('logout',[ApiAuthController::class,'logout'])
                  ->middleware('auth:sanctum');
            });
    }
}
