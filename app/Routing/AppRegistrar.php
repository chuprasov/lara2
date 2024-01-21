<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;
use Services\Telegram\TelegramBotApiContract;

class AppRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/', HomeController::class)->name('home');

            Route::get('/storage/images/{dir}/{method}/{size}/{file}', ThumbnailController::class)->name('thumbnail');

            /* route::get('/telegram/{message}', function (string $message) {
                $result = app(TelegramBotApiContract::class)::sendMessage(
                    env('TELEGRAM_TOKEN', ''),
                    (int) env('TELEGRAM_CHAT_ID', 0),
                    $message
                );

                return $result;
            }); */
        });
    }
}
