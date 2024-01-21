<?php

namespace Tests\Unit\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
    public function test_send_message_success(): void
    {
        Http::fake([
            TelegramBotApi::HOST.'*' => Http::response(['ok' => true]),
        ]);

        $result = TelegramBotApi::sendMessage(
            env('TELEGRAM_TOKEN', ''),
            (int) env('TELEGRAM_CHAT_ID', 0),
            'Unit test TelegramBotApi'
        );

        $this->assertTrue($result);
    }

    public function test_send_message_fake_success(): void
    {
        TelegramBotApi::fake()->returnTrue();

        $result = app(TelegramBotApiContract::class)::sendMessage(
            env('TELEGRAM_TOKEN', ''),
            (int) env('TELEGRAM_CHAT_ID', 0),
            'Unit test TelegramBotApi'
        );

        $this->assertTrue($result);
    }

    public function test_send_message_fake_fail(): void
    {
        TelegramBotApi::fake()->returnFalse();

        $result = app(TelegramBotApiContract::class)::sendMessage(
            env('TELEGRAM_TOKEN', ''),
            (int) env('TELEGRAM_CHAT_ID', 0),
            'Unit test TelegramBotApi'
        );

        $this->assertFalse($result);
    }
}
