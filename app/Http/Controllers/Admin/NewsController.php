<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsCreateRequest;
use App\Http\Requests\Admin\NewsUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\Tag;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsItems = News::query()
            ->with(['category', 'author', 'tags'])
            ->latest()
            ->get();

        return view('admin.news.index', compact('newsItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('name')->get();

        return view('admin.news.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsCreateRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $imagePath = $this->handleFileUpload($request, 'image', null, 'news');

            $news = News::create($this->buildNewsPayload($validated, $imagePath));

            $news->tags()->sync($this->resolveTagIds($validated['tags']));

            DB::commit();

            return redirect()->route('admin.news.index')
                ->with('success', __('news.created_successfully'));
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::error('News creation failed', [
                'message' => $exception->getMessage(),
                'input' => $request->except(['_token']),
            ]);

            return redirect()->back()
                ->with('error', __('news.creation_failed'))
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return redirect()->route('admin.news.edit', $news->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        $news->load('tags');
        $languages = Language::where('is_active', true)->orderBy('name')->get();

        return view('admin.news.edit', compact('news', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsUpdateRequest $request, News $news)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $imagePath = $this->handleFileUpload($request, 'image', $news->image, 'news');

            $news->update($this->buildNewsPayload($validated, $imagePath, $news));
            $news->tags()->sync($this->resolveTagIds($validated['tags']));

            DB::commit();

            return redirect()->route('admin.news.index')
                ->with('success', __('news.updated_successfully'));
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::error('News update failed', [
                'news_id' => $news->id,
                'message' => $exception->getMessage(),
                'input' => $request->except(['_token', '_method']),
            ]);

            return redirect()->back()
                ->with('error', __('news.update_failed'))
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        try {
            $this->handleFileRemoval($news->image);
            $news->delete();

            return response()->json([
                'status' => 'success',
                'message' => __('news.deleted_successfully'),
            ]);
        } catch (\Throwable $exception) {
            Log::error('News deletion failed', [
                'news_id' => $news->id,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => __('news.deletion_failed'),
            ], 500);
        }
    }

    public function fetchCategory(Request $request): JsonResponse
    {
        $categories = Category::query()
            ->where('language', $request->string('lang')->toString())
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($categories);
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);

        if ($baseSlug === '') {
            $baseSlug = 'news-item';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (News::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function buildNewsPayload(array $validated, ?string $imagePath, ?News $news = null): array
    {
        $payload = [
            'language' => $validated['language'],
            'category_id' => (int) $validated['category'],
            'author_id' => $news?->author_id ?? Auth::guard('admin')->id(),
            'image' => $imagePath,
            'title' => $validated['title'],
            'slug' => $news && $news->title === $validated['title'] ? $news->slug : $this->generateUniqueSlug($validated['title']),
            'content' => $validated['content'],
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'is_breaking_news' => $validated['is_breaking_news'] ?? false,
            'show_at_slider' => $validated['show_at_slider'] ?? false,
            'show_at_popular' => $validated['show_at_popular'] ?? false,
            'status' => $validated['status'] ?? false,
        ];

        if ($news && ! $imagePath) {
            $payload['image'] = $news->image;
        }

        return $payload;
    }

    private function resolveTagIds(string $tagString): array
    {
        return collect(explode(',', $tagString))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->map(fn ($tag) => preg_replace('/\s+/', ' ', $tag))
            ->map(fn ($tag) => Str::lower($tag))
            ->unique()
            ->map(fn ($tagName) => Tag::firstOrCreate(['name' => $tagName])->id)
            ->values()
            ->all();
    }
}
