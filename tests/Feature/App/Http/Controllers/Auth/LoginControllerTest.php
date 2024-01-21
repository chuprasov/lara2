<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_success(): void
    {
        $this
            ->get(route('login'))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_login_success(): void
    {
        $user = $this->getOrCreateTestUser();

        $request = [
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ];

        $response = $this->post(route('authenticate'), $request);

        $response
            ->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fail(): void
    {
        $request = [
            'email' => self::USER_EMAIL,
            'password' => str()->random(8),
        ];

        $this->post(route('authenticate'), $request);

        $this->assertGuest();
    }

    public function test_logout_success(): void
    {
        $user = $this->getOrCreateTestUser();

        $this->assertDatabaseHas('users', [
            'email' => self::USER_EMAIL,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('logout'));

        $response
            ->assertValid()
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
