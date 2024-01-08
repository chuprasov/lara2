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

        $password = str()->random(8);

        $this
            ->followingRedirects()
            ->from(route('password.reset', [
                'token' => $token,
            ]))
            ->post(route('updatePassword'), [
                'token' => $token,
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password,
            ])
            ->assertSuccessful()
            ->assertSee(__('passwords.reset'));

        $user->refresh();

        $this->assertFalse(Hash::check(self::USER_EMAIL, $user->password));

        $this->assertTrue(Hash::check($password, $user->password));
    }
}
