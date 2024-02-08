<?php

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

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
