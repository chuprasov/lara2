<?php

namespace Tests\Feature\App\Http\Controllers;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class LoginControllerTest extends TestCase
{
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

        $response->assertValid()->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_success(): void
    {
        $this->assertDatabaseHas('users', [
            'email' => self::USER_EMAIL,
        ]);

        $user = $this->getTestUser();

        $response = $this->actingAs($user)->delete(route('logout'));

        $response->assertValid()->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
