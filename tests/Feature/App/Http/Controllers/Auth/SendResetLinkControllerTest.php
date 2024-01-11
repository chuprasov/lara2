<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendResetLinkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_page_success(): void
    {
        $this
            ->get(route('forgotPassword'))
            ->assertOk()
            ->assertSee('Забыл пароль')
            ->assertViewIs('auth.forgot-password');
    }

    public function test_handle_success(): void
    {
        Notification::fake();

        $user = $this->getOrCreateTestUser();

        $this
            ->followingRedirects()
            ->from(route('forgotPassword'))
            ->post(route('sendResetLink'), [
                'email' => $user->email,
            ])
            ->assertSuccessful()
            ->assertSee(__('passwords.sent'));

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
