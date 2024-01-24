<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Support\SessionRegenerator;

class LoginController extends Controller
{
    public function page()
    {
        return view('auth.login');
    }

    public function handle(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (SessionRegenerator::run(fn () => auth()->attempt($credentials))) {
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Неправильный логин или пароль',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        SessionRegenerator::run(fn () => auth()->logout());

        return redirect(route('home'));
    }
}
