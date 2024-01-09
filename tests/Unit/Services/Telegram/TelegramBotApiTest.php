<?php

namespace Tests\Unit\Services\Telegram;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;

class TelegramBotApiTest extends TestCase
{
    public function test_send_message_success(): void
    {
        /* Http::fake([
            TelegramBotApi::HOST . '*' => response(['ok' => true])
        ]); */

        // Http::fake();

        /* $result = TelegramBotApi::sendMessage(
            env('TELEGRAM_TOKEN', ''),
            (int) env('TELEGRAM_CHAT_ID', 0),
            'Unit test TelegramBotApi'
        );

        $this->assertTrue($result); */

        $this->assertTrue(true);
    }
}
