<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Logging\Telegram\TelegramLogger;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Exceptions\TelegramBotApiException;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SendResetLinkController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Auth\UpdatePasswordController;

// Log::channel('telegram')->debug('Test 111');

Route::get('/', HomeController::class)->name('home');

/* route::get('/flash/{level}', function(string $level) {
    return redirect()->route('home')->with($level, $level . '! Test flash message');
}); */

/*
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
 */

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


