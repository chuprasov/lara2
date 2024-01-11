<?php

namespace Tests\Feature\Auth\DTOs;

use Domain\Auth\Contracts\RegisterUserContract;
use Tests\TestCase;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class NewUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_created_success(): void
    {
        $action = app(RegisterUserContract::class);

        $action(NewUserDTO::fromRequest(new Request([
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ])));

        $this->assertDatabaseHas('users', [
            'email' => self::USER_EMAIL,
        ]);

    }

}
