<?php

declare(strict_types=1);

namespace Support;

use App\Events\AfterSessionRegenerated;
use Closure;

class SessionRegenerator
{
    public static function run(string $old = null, Closure $closure = null): void
    {
        $oldSID = cart()->cartIdentityStorage->get();

        if (!is_null($closure)) {
            $closure();
        }

        if (is_null($old)) {
            request()->session()->regenerate();
            request()->session()->regenerateToken();
        }

        event(new AfterSessionRegenerated(
            $old ?? $oldSID,
            cart()->cartIdentityStorage->get()
        ));
    }
}
