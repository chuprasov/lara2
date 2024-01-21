<?php

namespace Services\Telegram;

final class TelegramBotApiFake
{
    protected static bool $success = true;

    public function returnTrue(): static
    {
        self::$success = true;

        return $this;
    }

    public function returnFalse(): static
    {
        static::$success = false;

        return $this;
    }

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        return static::$success;
    }
}
