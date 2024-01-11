<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Notifications\NewUserNotification;
use App\Listeners\SendEmailNewUserListener;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function userRequest(): array
    {
        return [
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
            'password_confirmation' => self::USER_PASSWORD,
        ];
    }

    public function test_page_success(): void
    {
        $this
            ->get(route('register'))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.register');
    }

    public function test_invalid_confirmation(): void
    {
        $request = $this->userRequest();

        $request['password_confirmation'] = '123';

        $this->deleteTestUser();

        $this
            ->post(route('store'), $request)
            ->assertInvalid(['password']);
    }

    public function test_handle_success(): void
    {
        // Event::fake();

        $this->deleteTestUser();

        $request = $this->userRequest();

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(route('store'), $request);

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $user = $this->getTestUser();

        /* Event::assertDispatched(Registered::class);
        Event::assertListening(
            Registered::class,
            SendEmailNewUserListener::class
        );

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo(
            $user,
            NewUserNotification::class
        ); */

        $response->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_event(): void
    {
        Event::fake();

        $this->deleteTestUser();

        $this->post(route('store'), $this->userRequest());

        Event::assertDispatched(Registered::class);
        Event::assertListening(
            Registered::class,
            SendEmailNewUserListener::class
        );
    }

    public function test_notification_send(): void
    {
        $this->deleteTestUser();

        $this->post(route('store'), $this->userRequest());

        Notification::assertSentTo(
            $this->getTestUser(),
            NewUserNotification::class
        );
    }
}
