@extends('frontend.layouts.master')

@section('title', $news->meta_title ?: $news->title)
@section('meta_description', $news->meta_description)
@section('content')
<section class="pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article>
                    <div class="mb-3 text-uppercase small text-muted">
                        {{ $news->category?->name ?? 'General' }} | {{ strtoupper($language) }} |
                        <i class="fa fa-eye"></i> {{ convertToKFormat($news->views) }} views
                    </div>
                    <h1 class="mb-3">{{ $news->title }}</h1>
                    <div class="mb-4 text-muted">
                        by {{ $news->author?->name ?? 'Admin' }} | {{ $news->created_at->format('M d, Y') }}
                    </div>
                    <div class="mb-4">
                        <img src="{{ $news->image ? asset('storage/' . $news->image) : asset('frontend/assets/images/newsimage8.png') }}" alt="{{ $news->title }}" class="img-fluid w-100">
                    </div>
                    <div class="mb-4">
                        {!! $news->content !!}
                    </div>

                    @if($news->tags->isNotEmpty())
                        <div class="mb-4">
                            <h5>Tags</h5>
                            @foreach($news->tags as $tag)
                                <span class="badge badge-light border mr-2 mb-2">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </article>

                <div class="mt-5">
                    <h4 class="border_section">Related News</h4>
                    <div class="row mt-4">
                        @forelse($relatedNews as $item)
                            <div class="col-md-6 mb-4">
                                <div class="card__post h-100">
                                    <div class="card__post__body card__post__transition">
                                        <a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">
                                            <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('frontend/assets/images/news2.jpg') }}" class="img-fluid" alt="{{ $item->title }}">
                                        </a>
                                        <div class="card__post__content bg__post-cover">
                                            <div class="card__post__category">{{ $item->category?->name ?? 'General' }}</div>
                                            <div class="card__post__title">
                                                <h5><a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">{{ $item->title }}</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted">No related news found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Recent Posts Section -->
                <aside class="wrapper__list__article mb-4">
                    <h4 class="border_section">Recent Posts</h4>

                    @forelse($recentNews as $key => $item)
                        @if($key < 3)
                            <!-- Small Card (First 3) -->
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('frontend/assets/images/newsimage8.png') }}"
                                             alt="{{ $item->title }}"
                                             class="img-fluid rounded-start"
                                             style="height: 80px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body p-2">
                                            <small class="text-muted d-block mb-1">{{ $item->created_at->format('M d, Y') }}</small>
                                            <h6 class="card-title mb-0">
                                                <a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}"
                                                   class="text-dark text-decoration-none">
                                                    {{ truncate($item->title, 40) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">by {{ $item->author?->name ?? 'Admin' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($key == 3)
                            <!-- Large Card (4th Item) -->
                            <div class="card mb-3">
                                <div class="card-img-wrapper" style="height: 150px; overflow: hidden;">
                                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('frontend/assets/images/news2.jpg') }}"
                                         alt="{{ $item->title }}"
                                         class="card-img-top"
                                         style="height: 100%; object-fit: cover;">
                                </div>
                                <div class="card-body">
                                    <span class="badge badge-primary mb-2">{{ $item->category?->name ?? 'General' }}</span>
                                    <h5 class="card-title">
                                        <a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}"
                                           class="text-dark text-decoration-none">
                                            {{ $item->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted mb-2">
                                        {{ truncate(strip_tags($item->content), 80) }}
                                    </p>
                                    <small class="text-muted">
                                        by {{ $item->author?->name ?? 'Admin' }} | {{ $item->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-muted">No recent posts available.</p>
                    @endforelse
                </aside>

                <!-- Popular Posts Section -->
                <aside class="wrapper__list__article">
                    <h4 class="border_section">Popular Post</h4>
                    <div class="wrapper__list-number">
                        @forelse($popularNews as $item)
                            <div class="card__post__list">
                                <div class="list-number"><span>{{ $loop->iteration }}</span></div>
                                <a href="{{ route('news.index', ['lang' => $language, 'category' => $item->category?->slug]) }}" class="category">{{ $item->category?->name ?? 'General' }}</a>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <h5><a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">{{ $item->title }}</a></h5>
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
