<?php

use App\Exceptions\TelegramBotApiException;
use App\Logging\Telegram\TelegramLogger;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    // Log::channel('telegram')->debug('Test 111');
    return view('welcome');
});
