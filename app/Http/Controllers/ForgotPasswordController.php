<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function requestForm()
    {
        return view('login.request');
    }
    public function showLinkRequestForm()
    {
        return view('login.email');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) {
            return back()->withErrors(['email' => __('We could not find a customer with that email address.')]);
        }
        $response = $this->broker()->sendResetLink(
            ['email' => $request->email]
        );
        return $response == Password::RESET_LINK_SENT
            ? redirect()->route('request')->with('status', __('Password reset link sent. Please check your email.'))
            : back()->withErrors(['email' => __($response)]);
    }
    public function showResetForm($token)
        {
            return view('login.reset')->with(['token' => $token, 'email' => request()->email]);
        }
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
                Auth::login($user);
            }
        );
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
    protected function broker()
    {
        return Password::broker();
    }
}
