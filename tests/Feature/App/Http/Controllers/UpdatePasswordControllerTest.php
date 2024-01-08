<?php

namespace Tests\Feature\App\Http\Controllers;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordControllerTest extends TestCase
{
    public function test_page_success(): void
    {
        // $token = app('auth.password.broker')->createToken($user);
        $token = str()->random(60);

        $this
            ->get(route('password.reset', ['token' => $token]))
            ->assertOk()
            ->assertSee('Изменить пароль')
            ->assertViewIs('auth.reset-password');
    }

    public function test_handle_success(): void
    {
        $user = $this->getTestUser();
        $token = app('auth.password.broker')->createToken($user);

        $this
            ->followingRedirects()
            ->from(route('password.reset', [
                'token' => $token,
            ]))
            ->post(route('updatePassword'), [
                'token' => $token,
                'email' => $user->email,
                'password' => self::USER_PASSWORD,
                'password_confirmation' => self::USER_PASSWORD,
            ])
            ->assertSuccessful()
            ->assertSee(__('passwords.reset'));

        $user->refresh();

        $this->assertTrue(Hash::check(self::USER_PASSWORD, $user->password));
    }
}
