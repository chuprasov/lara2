<?php

namespace Tests;

use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    const USER_NAME = 'user_test';
    const USER_EMAIL = 'user_test@gmail.com';
    const USER_PASSWORD = 'password';

    public function getUserRequest()
    {
        return [
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
            'password_confirmation' => self::USER_PASSWORD,
        ];
    }
    public function getTestUser()
    {
        $user = User::query()->where(['email' => self::USER_EMAIL])->first();

        return $user;
    }

    public function getOrCreateTestUser()
    {
        $request = $this->getUserRequest();

        $user = User::query()->where(['email' => self::USER_EMAIL])->first();

        if (!isset($user)) {
            $user = User::create($request);
        }

        return $user;
    }

}
