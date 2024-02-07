<?php

namespace Tests;

use Domain\Auth\Models\User;
use Domain\Cart\CartManager;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const USER_NAME = 'user_test';

    const USER_EMAIL = 'user_test@gmail.com';

    const USER_PASSWORD = 'password';

    protected $realQueue;

    public function setUp(): void
    {
        parent::setUp();

        $this->realQueue = Queue::getFacadeRoot();

        Notification::fake();
        Storage::fake();
        Queue::fake();

        CartManager::fake();

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
                'remember_token' => Str::random(10),
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
