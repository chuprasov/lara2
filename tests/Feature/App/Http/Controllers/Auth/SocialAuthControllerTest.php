<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
use Tests\TestCase;

class SocialAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private function mockSocialiteCallback(string|int $socialId): MockInterface
    {
        $user = $this->mock(SocialiteUser::class, function (MockInterface $mockInterface) use ($socialId) {
            $mockInterface->shouldReceive('getId')
                ->once()
                ->andReturn($socialId);

            $mockInterface->shouldReceive('getNickName')
                ->once()
                ->andReturn('test_social');

            $mockInterface->shouldReceive('getEmail')
                ->times(2)
                ->andReturn('test_social@gmail.com');
        });

        Socialite::shouldReceive('driver->user')
            ->once()
            ->andReturn($user);

        return $user;
    }

    public function callbackRequest(string $driver): TestResponse
    {
        return $this->get(route('socialAuth', ['socialName' => $driver]));
    }

    public function socialAuthSuccess(string $driver): void
    {
        $this->mockSocialiteCallback('0123456789');

        $response = $this->callbackRequest($driver);

        $response
            ->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }

    public function test_github_auth_success(): void
    {
        $this->socialAuthSuccess('github');
    }

    public function test_google_auth_success(): void
    {
        $this->socialAuthSuccess('google');
    }
}
