<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Domain\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\PasswordUpdateRequest;

class UpdatePasswordController extends Controller
{
    public function page(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function handle(PasswordUpdateRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('info', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
