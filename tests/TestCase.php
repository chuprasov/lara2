<?php

namespace Tests;

use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const USER_NAME = 'user_test';

    const USER_EMAIL = 'user_test@gmail.com';

    const USER_PASSWORD = 'password';

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        Http::preventStrayRequests();
    }

    public function getTestUser()
    {
        $user = User::query()
            ->where(['email' => self::USER_EMAIL])
            ->first();

        return $user;
    }

    public function getOrCreateTestUser()
    {
        $user = $this->getTestUser();

        if (! isset($user)) {
            $user = User::create([
                'name' => self::USER_NAME,
                'email' => self::USER_EMAIL,
                'password' => bcrypt(self::USER_PASSWORD),
            ]);
        }

        return $user;
    }

    public function deleteTestUser(): void
    {
        $user = $this->getTestUser();

        if (isset($user)) {
            $user->delete();
        }
    }
}
