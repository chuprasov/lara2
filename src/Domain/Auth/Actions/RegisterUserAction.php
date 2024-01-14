<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterUserAction implements RegisterUserContract
{
    public function __invoke(NewUserDTO $newUserDTO)
    {
        $user = User::create([
            'name' => $newUserDTO->name,
            'email' => $newUserDTO->email,
            'password' => bcrypt($newUserDTO->password),
        ]);

        event(new Registered($user));

        return $user;
    }
}
