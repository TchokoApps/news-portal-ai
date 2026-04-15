<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCategoryStoreRequest;
use App\Http\Requests\AdminCategoryUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::where('is_active', true)->get();
        return view('admin.category.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::where('is_active', true)->get();
        return view('admin.category.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCategoryStoreRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['slug'] = $this->generateUniqueSlug(
                $validated['name'],
                $validated['language']
            );

            Category::create($validated);

            return redirect()->route('admin.category.index')
                           ->with('success', __('categories.created_successfully'));
        } catch (\Exception $e) {
            Log::error('Category creation failed', [
                'message' => $e->getMessage(),
                'input' => $request->except(['_token']),
            ]);

            return redirect()->back()
                           ->with('error', __('categories.creation_failed'))
                           ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $languages = Language::where('is_active', true)->get();
        return view('admin.category.edit', compact('category', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminCategoryUpdateRequest $request, Category $category)
    {
        try {
            $validated = $request->validated();

            if (
                $validated['name'] !== $category->name
                || $validated['language'] !== $category->language
            ) {
                $validated['slug'] = $this->generateUniqueSlug(
                    $validated['name'],
                    $validated['language'],
                    $category->id
                );
            }

            $category->update($validated);

            return redirect()->route('admin.category.index')
                           ->with('success', __('categories.updated_successfully'));
        } catch (\Exception $e) {
            Log::error('Category update failed', [
                'category_id' => $category->id,
                'message' => $e->getMessage(),
                'input' => $request->except(['_token', '_method']),
            ]);

            return redirect()->back()
                           ->with('error', __('categories.update_failed'))
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json([
                'status' => 'success',
                'message' => __('categories.deleted_successfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('categories.deletion_failed'),
            ], 500);
        }
    }

    private function generateUniqueSlug(string $name, string $language, ?int $ignoreCategoryId = null): string
    {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = Str::slug($language . ' category');
        }

        $slug = $baseSlug;
        $counter = 1;

        while ($this->slugExists($slug, $ignoreCategoryId)) {
            $slug = $baseSlug . '-' . Str::slug($language);

            if ($counter > 1) {
                $slug .= '-' . $counter;
            }

            $counter++;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $ignoreCategoryId = null): bool
    {
        return Category::query()
            ->when($ignoreCategoryId, fn ($query) => $query->where('id', '!=', $ignoreCategoryId))
            ->where('slug', $slug)
            ->exists();
    }
}
