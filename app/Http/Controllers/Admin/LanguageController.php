<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:languages',
            'code' => 'required|string|unique:languages',
            'flag_code' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Language::create($validated);
        return redirect()->route('admin.language.index')->with('success', 'Language created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        return view('admin.language.show', compact('language'));
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
    public function update(Request $request, Language $language)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:languages,name,' . $language->id,
            'code' => 'required|string|unique:languages,code,' . $language->id,
            'flag_code' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $language->update($validated);
        return redirect()->route('admin.language.index')->with('success', 'Language updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->route('admin.language.index')->with('success', 'Language deleted successfully.');
    }
}
