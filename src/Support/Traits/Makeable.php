<?php

declare(strict_types=1);

namespace Support\Traits;

trait Makeable
{
    public static function make(mixed ...$args)
    {
        return new static(...$args);
    }

}
