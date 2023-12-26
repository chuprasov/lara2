<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class TelegramBotApiException extends Exception
{
    public function render(Request $request)
    {
        return response()->json([]);
    }
}
