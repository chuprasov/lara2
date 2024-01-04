<?php

use App\Exceptions\TelegramBotApiException;
use App\Logging\Telegram\TelegramLogger;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    // Log::channel('telegram')->debug('Test 111');
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    // Log::channel('telegram')->debug('Test 111');
    return view('auth.index');
})->name('login');

Route::get('/register', function () {
    // Log::channel('telegram')->debug('Test 111');
    return view('auth.register');
})->name('register');
