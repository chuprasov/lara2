<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotRequest;
use Illuminate\Support\Facades\Password;

class SendResetLinkController extends Controller
{
    public function page()
    {
        return view('auth.forgot-password');
    }

    public function handle(ForgotRequest $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['info' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
