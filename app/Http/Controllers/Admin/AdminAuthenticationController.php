<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminResetPasswordRequest;
use App\Http\Requests\HandleLoginRequest;
use App\Http\Requests\SendResetLinkRequest;
use App\Mail\AdminSendResetLink;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
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
            return back()->withErrors(['email' => __('Email not found in our system.')]);
        }

        // Generate a random token
        $token = Str::random(64);

        // Store the token in the admin's remember_token column
        $admin->remember_token = $token;
        $admin->save();

        // Send the reset link email
        Mail::to($admin->email)->send(new AdminSendResetLink($admin, $token));

        return back()->with('status', __('Password reset link has been sent to your email address.'));
    }

    public function resetPassword(string $token): View
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
        ]);
    }

    public function handleResetPassword(AdminResetPasswordRequest $request): RedirectResponse
    {
        // Get the token from the request
        $token = $request->input('token');

        // Find admin by email and token
        $admin = Admin::where('email', $request->email)
            ->where('remember_token', $token)
            ->first();

        // If admin not found, token is invalid
        if (!$admin) {
            return back()->withErrors(['token' => __('The reset token is invalid or has expired.')]);
        }

        // Update the password
        $admin->password = Hash::make($request->password);

        // Clear the token
        $admin->remember_token = null;

        // Save changes
        $admin->save();

        // Redirect to login with success message
        return redirect()->route('admin.login')->with('status', __('Password reset successfully. Please login with your new password.'));
    }
}
