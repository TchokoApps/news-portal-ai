<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Debug: Log the current request and auth status
        \Log::debug('Admin middleware check', [
            'path' => $request->path(),
            'admin_guard_check' => auth()->guard('admin')->check(),
            'admin_user' => auth()->guard('admin')->user() ? auth()->guard('admin')->user()->email : 'no user',
            'session_id' => session()->getId(),
            'cookies' => array_keys($request->cookies->all()),
        ]);

        if (!auth()->guard('admin')->check()) {
            \Log::warning('Admin not authenticated, redirecting to login', [
                'path' => $request->path(),
                'admin_user' => auth()->guard('admin')->user(),
            ]);
            return redirect()->route('admin.login')->with('error', 'Please login first');
        }

        return $next($request);
    }
}
