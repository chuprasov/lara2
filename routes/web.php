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
    Route::get('/forgot-password', 'forgotPassword')->middleware('guest')->name('forgotPassword');
    Route::post('/send-reset-link', 'sendResetLink')->middleware('guest')->name('sendResetLink');
    Route::get('/reset-password/{token}', 'resetPassword')->middleware('guest')->name('password.reset');
    Route::post('/update-password', 'updatePassword')->middleware('guest')->name('updatePassword');

    Route::get('/auth/{socialName}/redirect', 'socialRedirect')->middleware('guest')->name('socialRedirect');
    Route::get('/auth/{socialName}/callback', 'socialAuth')->middleware('guest')->name('socialAuth');
});

/* route::get('/flash/{level}', function(string $level) {
    return redirect()->route('home')->with($level, $level . '! Test flash message');
}); */

