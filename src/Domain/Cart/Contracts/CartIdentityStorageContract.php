<?php

declare(strict_types=1);

namespace Domain\Cart\Contracts;

interface CartIdentityStorageContract
{
    public static function get(): string;
}
