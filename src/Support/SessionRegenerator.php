<?php

declare(strict_types=1);

namespace Support;

use App\Events\AfterSessionRegenerated;
use Closure;

class SessionRegenerator
{
    public static function run(Closure $closure)
    {
        $oldSID = cart()->cartIdentityStorage->get();

        $response = null;

        if (! is_null($closure)) {
            $response = $closure();
        }

        request()->session()->regenerate();
        request()->session()->regenerateToken();

        event(new AfterSessionRegenerated(
            $oldSID,
            cart()->cartIdentityStorage->get()
        ));

        return $response;
    }
}
