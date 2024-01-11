<?php

namespace Services\Telegram;

use Exception;
use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApiFake;
use App\Exceptions\TelegramBotApiException;

final class TelegramBotApi
{
    public const HOST = 'api.telegram.org/bot';

    public static function fake(): TelegramBotApiFake
    {
        return app()->instance(
            TelegramBotApiContract::class,
            new TelegramBotApiFake()
        );
    }

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text,
            ])->throw()->json();

            return $response['ok'] ?? false;

        } catch (Exception $e) {
            report(new TelegramBotApiException($e->getMessage()));

            return false;
        };
    }
}
