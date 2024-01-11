<?php

namespace Tests\Feature\Auth\DTOs;

use Tests\TestCase;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    public function test_instance_created_form_request(): void
    {
        $user = NewUserDTO::fromRequest(new Request([
            'name' => self::USER_NAME,
            'email' => self::USER_EMAIL,
            'password' => self::USER_PASSWORD,
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $user);
    }

}
