<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Handle language change request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $languageCode = $request->string('language_code')->toString();

        session(['language' => $languageCode]);

        return response()->json([
            'status' => 'success',
            'message' => 'Language changed successfully'
        ]);
    }
}
