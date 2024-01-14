<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Domain\Auth\Contracts\RegisterUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function page()
    {
        return view('auth.register');
    }

    public function handle(RegisterRequest $request, RegisterUserContract $action): RedirectResponse
    {
        $user = $action(NewUserDTO::fromRequest($request));

        auth()->login($user);

        return redirect()->intended(route('home'));
    }
}
