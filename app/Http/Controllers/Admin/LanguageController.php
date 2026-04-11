<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLanguageStoreRequest;
use App\Http\Requests\AdminLanguageUpdateRequest;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.language.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminLanguageStoreRequest $request)
    {
        try {
            $validated = $request->validated();

            Language::create($validated);

            return redirect()->route('admin.language.index')
                           ->with('success', __('languages.created_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', __('languages.creation_failed'))
                           ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        return view('admin.language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminLanguageUpdateRequest $request, Language $language)
    {
        try {
            $validated = $request->validated();

            $language->update($validated);

            return redirect()->route('admin.language.index')
                           ->with('success', __('languages.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', __('languages.update_failed'))
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        try {
            // Prevent deletion of default language
            if ($language->is_default) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('languages.cannot_delete_default'),
                ], 409);
            }

            $language->delete();

            return response()->json([
                'status' => 'success',
                'message' => __('languages.deleted_successfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('languages.deletion_failed'),
            ], 500);
        }
    }
}
