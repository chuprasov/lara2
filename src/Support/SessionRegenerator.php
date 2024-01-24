<?php

declare(strict_types=1);

namespace Support;

use App\Events\AfterSessionRegenerated;
use Closure;

class SessionRegenerator
{
    public static function run(Closure $closure)
    {
        $oldCIS = cart()->cartIdentityStorage->get();

        $response = null;

        if (! is_null($closure)) {
            $response = $closure();
        }

        request()->session()->regenerate();
        request()->session()->regenerateToken();

        event(new AfterSessionRegenerated(
            $oldCIS,
            cart()->cartIdentityStorage->get()
        ));

        return $response;
    }
}
