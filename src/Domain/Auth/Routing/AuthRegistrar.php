<?php

declare(strict_types=1);

namespace Domain\Auth\Routing;

use App\Contracts\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Routing\Registrar;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SendResetLinkController;
use App\Http\Controllers\Auth\UpdatePasswordController;

class AuthRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(LoginController::class)->group(function () {
                Route::get('/login', 'page')->name('login');
                Route::post('/login', 'handle')->name('authenticate');
                Route::delete('/logout', 'logout')->name('logout');
            });

            Route::controller(RegisterController::class)->group(function () {
                Route::get('/register', 'page')->name('register');
                Route::post('/store', 'handle')->name('store');
            });

            Route::controller(SendResetLinkController::class)->group(function () {
                Route::get('/forgot-password', 'page')->middleware('guest')->name('forgotPassword');
                Route::post('/send-reset-link', 'handle')->middleware('guest')->name('sendResetLink');
            });

            Route::controller(UpdatePasswordController::class)->group(function () {
                Route::get('/reset-password/{token}', 'page')->middleware('guest')->name('password.reset');
                Route::post('/update-password', 'handle')->middleware('guest')->name('updatePassword');
            });

            Route::controller(SocialController::class)->group(function () {
                Route::get('/auth/{socialName}/redirect', 'redirect')->middleware('guest')->name('socialRedirect');
                Route::get('/auth/{socialName}/callback', 'auth')->middleware('guest')->name('socialAuth');
            });
        });
    }
}
