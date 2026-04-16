@extends('frontend.layouts.master')

@section('title', 'News')
@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <h1 class="mb-2">Latest News</h1>
                <p class="text-muted mb-0">Language: {{ strtoupper($language) }}</p>
            </div>
            <div class="col-md-4">
                <form method="GET" action="{{ route('news.index') }}" class="d-flex flex-column flex-md-row gap-2">
                    <input type="hidden" name="lang" value="{{ $language }}">
                    <select class="form-control" name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @forelse($newsItems as $news)
                        <div class="col-md-6 mb-4">
                            <article class="card__post card__post-list card__post__transition h-100 bg-white p-2">
                                <div class="card__post__body">
                                    <a href="{{ route('news.show', ['slug' => $news->slug, 'lang' => $language]) }}">
                                        <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('frontend/assets/images/newsimage8.png') }}" class="img-fluid mb-3" alt="{{ $news->title }}">
                                    </a>
                                    <div class="card__post__content">
                                        <div class="card__post__category mb-2">{{ $news->category?->name ?? 'General' }}</div>
                                        <div class="card__post__title">
                                            <h5>
                                                <a href="{{ route('news.show', ['slug' => $news->slug, 'lang' => $language]) }}">{{ $news->title }}</a>
                                            </h5>
                                        </div>
                                        <div class="card__post__author-info mb-2">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">by {{ $news->author?->name ?? 'Admin' }}</li>
                                                <li class="list-inline-item">{{ $news->created_at->format('M d, Y') }}</li>
                                            </ul>
                                        </div>
                                        <p class="text-muted mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($news->content), 120) }}</p>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light border">No published news found for this language.</div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-3">
                    {{ $newsItems->links() }}
                </div>
            </div>

            <div class="col-lg-4">
                <aside class="wrapper__list__article">
                    <h4 class="border_section">Popular Post</h4>
                    <div class="wrapper__list-number">
                        @forelse($popularNews as $item)
                            <div class="card__post__list">
                                <div class="list-number">
                                    <span>{{ $loop->iteration }}</span>
                                </div>
                                <a href="{{ route('news.index', ['lang' => $language, 'category' => $item->category?->slug]) }}" class="category">{{ $item->category?->name ?? 'General' }}</a>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <h5>
                                            <a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">{{ $item->title }}</a>
                                        </h5>
                                    </li>
                                </ul>
                            </div>
                        @empty
                            <p class="text-muted">No popular posts available.</p>
                        @endforelse
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
