<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminAuthenticationController extends Controller
{
    public function login(): View
    {
        return view('admin.auth.login');
    }
}
