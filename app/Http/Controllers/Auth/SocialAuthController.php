<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Domain\Auth\Models\User;
use Support\SessionRegenerator;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $socialName)
    {
        if (! in_array($socialName, ['github', 'google'])) {
            throw new \DomainException('Driver not supported');
        }

        try {
            return Socialite::driver($socialName)->redirect();
        } catch (\Throwable $th) {
            throw new \DomainException('Social Auth error');
        }
    }

    public function auth(string $socialName)
    {
        if (! in_array($socialName, ['github', 'google'])) {
            throw new \DomainException('Driver not supported');
        }

        try {
            $socialUser = Socialite::driver($socialName)->user();
        } catch (\Throwable $th) {
            throw new \DomainException('Social Auth error');
        }

        $user = User::updateOrCreate([
            'email' => $socialUser->getEmail(),
        ], [
            'name' => $socialUser->getNickName() ?? $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'password' => bcrypt(Str::random(20)),
        ]);

        $user[$socialName.'_id'] = $socialUser->getId();

        SessionRegenerator::run(null, fn() => auth()->login($user));

        return redirect(route('home'));
    }
}
