<?php

use App\Models\Language;

/**
 * Get the current language from session or default
 *
 * @return string Language code (e.g., 'en', 'bn')
 */
function getLanguage(): string
{
    try {
        // If language is already in session, return it
        if (session()->has('language')) {
            return session('language');
        }

        // Try to get default language from database
        $defaultLanguage = Language::query()
            ->where('is_default', true)
            ->where('is_active', true)
            ->first();

        if ($defaultLanguage) {
            setLanguage($defaultLanguage->code);
            return $defaultLanguage->code;
        }

        // Fallback to first active language
        $firstLanguage = Language::query()
            ->where('is_active', true)
            ->first();

        if ($firstLanguage) {
            setLanguage($firstLanguage->code);
            return $firstLanguage->code;
        }

        // Ultimate fallback
        setLanguage('en');
        return 'en';
    } catch (\Throwable $exception) {
        // If anything fails, return fallback
        session(['language' => 'en']);
        return 'en';
    }
}

/**
 * Set the current language in session
 *
 * @param string $code Language code
 * @return void
 */
function setLanguage(string $code): void
{
    session(['language' => $code]);
}

/**
 * Get all active languages
 *
 * @return \Illuminate\Database\Eloquent\Collection
 */
function getActiveLanguages()
{
    return Language::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->get();
}
