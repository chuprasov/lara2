<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Services\Telegram\TelegramBotApi;
use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Routing\Registrar;

class AppRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/', HomeController::class)->name('home');

            route::get('/telegram/{message}', function(string $message) {
                $result = TelegramBotApi::sendMessage(
                    env('TELEGRAM_TOKEN', ''),
                    (int) env('TELEGRAM_CHAT_ID', 0),
                    $message
                );

                return $result;
            });

            /* route::get('/flash/{level}', function(string $level) {
                return redirect()->route('home')->with($level, $level . '! Test flash message');
            }); */
            // Log::channel('telegram')->debug('Test 111');
        });
    }
}
