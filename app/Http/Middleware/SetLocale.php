<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Set Laravel's locale based on session language
     * This ensures all translations use the correct language
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get language from session, default to 'en'
        $language = session('language', 'en');

        // Map language codes to Laravel locale codes if needed
        // For example: 'bn' -> 'bn', 'en' -> 'en'
        $localeMapping = [
            'en' => 'en',
            'bn' => 'bn',
        ];

        $locale = $localeMapping[$language] ?? 'en';

        // Set Laravel's application locale
        app()->setLocale($locale);

        return $next($request);
    }
}
