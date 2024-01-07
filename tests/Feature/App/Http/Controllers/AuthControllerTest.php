<?php

namespace Tests\Feature\App\Http\Controllers;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Notifications\NewUserNotification;
use App\Listeners\SendEmailNewUserListener;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthControllerTest extends TestCase
{
    const USER_CREDENTIALS = [
        'name' => 'user333',
        'email' => 'user333@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    public function test_store_user_success(): void
    {
        Event::fake();
        Notification::fake();

        $request = self::USER_CREDENTIALS;

        $user = User::query()->where(['email' => $request['email']])->first();

        if (isset($user)) {
            $user->delete();
        }

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(route('store'), $request);

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $user = User::query()->where(['email' => $request['email']])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $response->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_page_success(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_register_page_success(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.register');
    }

    public function test_forgot_page_success(): void
    {
        $this->get(route('forgotPassword'))
            ->assertOk()
            ->assertSee('Забыл пароль')
            ->assertViewIs('auth.forgot-password');
    }

    public function test_reset_password_page_success(): void
    {
        $this->get(route('password.reset', ['token' => '123']))
            ->assertOk()
            ->assertSee('Изменить пароль')
            ->assertViewIs('auth.reset-password');
    }

    public function test_authenticate_success(): void
    {
        $request = [
            'email' => self::USER_CREDENTIALS['email'],
            'password' => self::USER_CREDENTIALS['password'],
        ];

        $response = $this->post(route('authenticate'), $request);

        $response->assertValid()->assertRedirect(route('home'));

        $user = User::query()->where(['email' => $request['email']])->first();

        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_success(): void
    {
        $this->assertDatabaseHas('users', [
            'email' => self::USER_CREDENTIALS['email'],
        ]);

        $user = User::query()->where(['email' => self::USER_CREDENTIALS['email']])->first();

        $response = $this->actingAs($user)->delete(route('logout'));

        $response->assertValid()->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_send_reset_link_success(): void
    {
        Notification::fake();

        $request = [
            'email' => self::USER_CREDENTIALS['email'],
        ];

        $response = $this->post(route('sendResetLink'), $request);

        $response->assertRedirect();

        $user = User::query()->where(['email' => self::USER_CREDENTIALS['email']])->first();

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
