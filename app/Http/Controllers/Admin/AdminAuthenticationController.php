<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HandleLoginRequest;
use Illuminate\Http\RedirectResponse;
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
}
