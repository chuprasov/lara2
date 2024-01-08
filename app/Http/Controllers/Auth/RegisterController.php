<?php

namespace App\Http\Controllers\Auth;

use Domain\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function page()
    {
        return view('auth.register');
    }

    public function handle(RegisterRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password'])
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->intended(route('home'));
    }
}
