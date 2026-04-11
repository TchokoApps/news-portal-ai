<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HandleLoginRequest;
use App\Http\Requests\SendResetLinkRequest;
use App\Mail\AdminSendResetLink;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminAuthenticationController extends Controller
{
    public function login(): View
    {
        return view('admin.auth.login');
    }

    public function handleLogin(HandleLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        return redirect()->route('admin.dashboard');
    }

    public function forgotPassword(): View
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(SendResetLinkRequest $request): RedirectResponse
    {
        // Get the admin by email
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Email not found in our system.']);
        }

        // Generate a random token
        $token = Str::random(64);

        // Store the token in the admin's remember_token column
        $admin->remember_token = $token;
        $admin->save();

        // Send the reset link email
        Mail::to($admin->email)->send(new AdminSendResetLink($admin, $token));

        return back()->with('status', 'Password reset link has been sent to your email address.');
    }
}
