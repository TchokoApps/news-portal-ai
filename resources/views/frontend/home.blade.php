@extends('frontend.layouts.master')

@section('title', 'Home')
@section('content')
<section class="pt-4 pb-5">
	<div class="container">
		@if($breakingNews->isNotEmpty())
			<div class="mb-5">
				<div class="d-flex align-items-center justify-content-between mb-3">
					<h3 class="mb-0">Breaking News</h3>
					<a href="{{ route('news.index', ['lang' => $language]) }}" class="text-uppercase small">View all</a>
				</div>
				<div class="row">
					@foreach($breakingNews as $item)
						<div class="col-md-4 mb-4">
							<div class="card__post h-100">
								<div class="card__post__body card__post__transition">
									<a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">
										<img src="{{ $item->image ? asset('storage/' . $item->image) : asset('frontend/assets/images/newsimage8.png') }}" class="img-fluid" alt="{{ $item->title }}">
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
					@endforeach
				</div>
			</div>
		@endif

		<div class="row">
			<div class="col-lg-8">
				@if($sliderNews->isNotEmpty())
					<div class="mb-5">
						<h3 class="mb-3">Featured Slider News</h3>
						<div class="row">
							@foreach($sliderNews as $item)
								<div class="col-md-6 mb-4">
									<article class="card__post card__post-list h-100 bg-white p-2">
										<a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">
											<img src="{{ $item->image ? asset('storage/' . $item->image) : asset('frontend/assets/images/news1.jpg') }}" class="img-fluid mb-3" alt="{{ $item->title }}">
										</a>
										<div class="card__post__content">
											<div class="card__post__category mb-2">{{ $item->category?->name ?? 'General' }}</div>
											<div class="card__post__title">
												<h5><a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">{{ $item->title }}</a></h5>
											</div>
											<p class="text-muted mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 110) }}</p>
										</div>
									</article>
								</div>
							@endforeach
						</div>
					</div>
				@endif

				<div>
					<div class="d-flex align-items-center justify-content-between mb-3">
						<h3 class="mb-0">Recent Posts</h3>
						<a href="{{ route('news.index', ['lang' => $language]) }}" class="text-uppercase small">Browse news</a>
					</div>
					<div class="row">
						@forelse($latestNews as $item)
							<div class="col-md-6 mb-4">
								<article class="card__post card__post-list h-100 bg-white p-2">
									<a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">
										<img src="{{ $item->image ? asset('storage/' . $item->image) : asset('frontend/assets/images/news2.jpg') }}" class="img-fluid mb-3" alt="{{ $item->title }}">
									</a>
									<div class="card__post__content">
										<div class="card__post__author-info mb-2">
											<ul class="list-inline mb-0">
												<li class="list-inline-item">{{ $item->author?->name ?? 'Admin' }}</li>
												<li class="list-inline-item">{{ $item->created_at->format('M d, Y') }}</li>
											</ul>
										</div>
										<div class="card__post__title">
											<h5><a href="{{ route('news.show', ['slug' => $item->slug, 'lang' => $language]) }}">{{ $item->title }}</a></h5>
										</div>
										<p class="text-muted mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 100) }}</p>
									</div>
								</article>
							</div>
						@empty
							<div class="col-12">
								<div class="alert alert-light border">No published news available yet.</div>
							</div>
						@endforelse
					</div>

					<div class="mt-3">
						{{ $latestNews->links() }}
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<aside class="wrapper__list__article mb-4">
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

				<aside class="wrapper__list__article mb-4">
					<h4 class="border_section">Categories</h4>
					<ul class="list-unstyled mb-0">
						@forelse($categories as $category)
							<li class="mb-2">
								<a href="{{ route('news.index', ['lang' => $language, 'category' => $category->slug]) }}">{{ $category->name }}</a>
							</li>
						@empty
							<li class="text-muted">No categories available.</li>
						@endforelse
					</ul>
				</aside>

				<aside class="wrapper__list__article">
					<h4 class="border_section">Tags</h4>
					@forelse($tags as $tag)
						<span class="badge badge-light border mr-2 mb-2">{{ $tag->name }}</span>
					@empty
						<p class="text-muted">No tags available.</p>
					@endforelse
				</aside>
			</div>
		</div>
	</div>
</section>
@endsection
