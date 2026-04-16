<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function home(Request $request)
    {
        $language = $this->resolveLanguage($request->query('lang'));
        $baseQuery = $this->publishedNewsQuery($language);

        $breakingNews = (clone $baseQuery)
            ->where('is_breaking_news', true)
            ->latest()
            ->take(5)
            ->get();

        $sliderNews = (clone $baseQuery)
            ->where('show_at_slider', true)
            ->latest()
            ->take(5)
            ->get();

        $popularNews = (clone $baseQuery)
            ->where('show_at_popular', true)
            ->latest()
            ->take(6)
            ->get();

        $latestNews = (clone $baseQuery)
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $categories = Category::query()
            ->where('language', $language)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $tags = Tag::query()
            ->whereHas('news', fn ($query) => $query->where('language', $language)->where('status', true))
            ->orderBy('name')
            ->take(20)
            ->get();

        return view('frontend.home', compact(
            'language',
            'breakingNews',
            'sliderNews',
            'popularNews',
            'latestNews',
            'categories',
            'tags'
        ));
    }

    public function index(Request $request)
    {
        $language = $this->resolveLanguage($request->query('lang'));

        $newsItems = $this->publishedNewsQuery($language)
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($categoryQuery) use ($request) {
                    $categoryQuery->where('slug', $request->string('category')->toString());
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $categories = Category::query()
            ->where('language', $language)
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $popularNews = $this->publishedNewsQuery($language)
            ->where('show_at_popular', true)
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.news.index', compact('newsItems', 'categories', 'popularNews', 'language'));
    }

    public function show(Request $request, string $slug)
    {
        $language = $this->resolveLanguage($request->query('lang'));

        $news = News::query()
            ->with(['category', 'author', 'tags'])
            ->where('status', true)
            ->where('language', $language)
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedNews = News::query()
            ->with(['category', 'author'])
            ->where('status', true)
            ->where('language', $language)
            ->where('category_id', $news->category_id)
            ->whereKeyNot($news->id)
            ->latest()
            ->take(4)
            ->get();

        $popularNews = News::query()
            ->with('category')
            ->where('status', true)
            ->where('language', $language)
            ->where('show_at_popular', true)
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.news.show', compact('news', 'relatedNews', 'popularNews', 'language'));
    }

    private function publishedNewsQuery(string $language)
    {
        return News::query()
            ->with(['category', 'author', 'tags'])
            ->where('status', true)
            ->where('language', $language);
    }

    private function resolveLanguage(?string $requestedLanguage): string
    {
        if ($requestedLanguage && Language::where('code', $requestedLanguage)->where('is_active', true)->exists()) {
            return $requestedLanguage;
        }

        return Language::query()
            ->where('is_default', true)
            ->value('code')
            ?? Language::query()->where('is_active', true)->value('code')
            ?? 'en';
    }
}
