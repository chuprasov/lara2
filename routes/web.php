<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Logging\Telegram\TelegramLogger;
use Laravel\Socialite\Facades\Socialite;
use App\Exceptions\TelegramBotApiException;

// Log::channel('telegram')->debug('Test 111');

Route::get('/', HomeController::class)->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::delete('/logout', 'logout')->name('logout');
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/forgot', 'forgot')->middleware('guest')->name('forgot');
    Route::post('/forgot', 'forgotPassword')->middleware('guest')->name('forgotPassword');
    Route::get('/reset-password/{token}', 'reset')->middleware('guest')->name('password.reset');
    Route::post('/reset', 'resetPassword')->middleware('guest')->name('resetPassword');

    Route::get('/auth/github/redirect', function () {
        return Socialite::driver('github')->redirect();
    })->middleware('guest')->name('githubAuth');

    Route::get('/auth/github/callback', 'githubAuth');
});
