<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Domain\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect(string $socialName)
    {
        if ($socialName !== 'github' && $socialName !== 'github') {
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
        if ($socialName !== 'github' && $socialName !== 'github') {
            throw new \DomainException('Driver not supported');
        }

        try {
            $socialUser = Socialite::driver($socialName)->user();
        } catch (\Throwable $th) {
            throw new \DomainException('Social Auth error');
        }

        $user = User::updateOrCreate([
            'email' => $socialUser->email,
        ], [
            'name' => $socialUser->nickname ?? $socialUser->name,
            'email' => $socialUser->email,
            'password' => bcrypt(Str::random(60)),
        ]);

        $user->socials()->updateOrCreate([
            'social_name' =>  $socialName,
        ], [
            'social_name' =>  $socialName,
            'social_id' =>  $socialUser->id,
        ]);

        // dd($user->socials()->where('social_name', 'github')->first());

        Auth::login($user);

        return redirect(route('home'));
    }

}
