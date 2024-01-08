<?php

namespace Tests;

use Domain\Auth\Actions\RegisterUserAction;
use Domain\Auth\Models\User;
use Domain\Auth\Contracts\RegisterUserContract;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const USER_NAME = 'user_test';
    const USER_EMAIL = 'user_test@gmail.com';
    const USER_PASSWORD = 'password';

    public function getTestUser()
    {
        $user = User::query()->where(['email' => self::USER_EMAIL])->first();

        return $user;
    }

    public function getOrCreateTestUser()
    {
        $user = User::query()->where(['email' => self::USER_EMAIL])->first();

        if (!isset($user)) {
            $user = User::create([
                'name' => self::USER_NAME,
                'email' => self::USER_EMAIL,
                'password' => bcrypt(self::USER_PASSWORD)
            ]);
        }

        return $user;
    }

}
