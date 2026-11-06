@extends('public.layout')

@section('title', ($article->meta_title ?: $article->title).' | 1000 Hills Rugby')
@section('meta_description', $article->meta_description ?: $article->excerpt_text)
@section('og_image', media_url($article->featured_image, 'uploads/NRC25/IMG_1906.JPG'))

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url($article->featured_image, 'uploads/NRC25/IMG_1906.JPG') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news.index') }}">News</a></li>
                    <li class="breadcrumb-item active">{{ $article->category }}</li>
                </ol>
            </nav>
            <span class="badge-category mb-3">{{ $article->category }}</span>
            <h1>{{ $article->title }}</h1>
            <p>{{ $article->excerpt_text }}</p>
            <div class="meta text-white-50 mt-3">
                <span><i class="bi bi-person me-1"></i>{{ $article->author ?: setting('site_name', '1000 Hills Rugby') }}</span>
                <span><i class="bi bi-calendar3 me-1"></i>{{ optional($article->published_at ?? $article->created_at)->format('d F Y') }}</span>
                <span><i class="bi bi-clock me-1"></i>{{ $article->reading_time }} min read</span>
                <span><i class="bi bi-eye me-1"></i>{{ number_format($article->views) }} views</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    @if($article->featured_image)
                        <div class="article-hero mb-4">
                            <img src="{{ media_url($article->featured_image) }}" alt="{{ $article->title }}">
                        </div>
                    @endif

                    <div class="article-body">
                        {!! $article->body !!}

                        @foreach($article->sections as $section)
                            @if($section->subtitle)
                                <h2>{{ $section->subtitle }}</h2>
                            @endif
                            {!! $section->content !!}
                            @if($section->images)
                                <div class="row g-3 my-2">
                                    @foreach($section->images as $image)
                                        <div class="col-sm-6">
                                            <img src="{{ media_url($image) }}" alt="{{ $section->subtitle ?: $article->title }}" class="w-100" loading="lazy">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($article->gallery)
                        <hr class="my-5">
                        <h3 class="mb-3">Gallery</h3>
                        <div class="row g-3">
                            @foreach($article->gallery as $image)
                                <div class="col-6 col-md-4">
                                    <a href="{{ media_url($image) }}" target="_blank" rel="noopener">
                                        <img src="{{ media_url($image) }}" alt="{{ $article->title }} gallery image" class="rounded-xl w-100" style="aspect-ratio:1; object-fit:cover;" loading="lazy">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-5 pt-4 border-top">
                        <a href="{{ route('news.index') }}" class="btn btn-outline-forest"><i class="bi bi-arrow-left me-1"></i>Back to news</a>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted-2 small">Share</span>
                            <div class="share-links">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on Facebook"><i class="bi bi-facebook"></i></a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener" aria-label="Share on X"><i class="bi bi-twitter-x"></i></a>
                                <a href="https://wa.me/?text={{ urlencode($article->title.' '.url()->current()) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                <a href="#" data-copy="{{ url()->current() }}" aria-label="Copy link"><i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="col-lg-4">
                    <div class="card-clean p-4 mb-4">
                        <h3 class="fs-5 mb-3">More from the club</h3>
                        @forelse($related as $item)
                            <a href="{{ route('news.show', $item) }}" class="d-flex gap-3 text-decoration-none py-2 {{ ! $loop->last ? 'border-bottom' : '' }}">
                                <img src="{{ media_url($item->featured_image, 'images/rugby-2.jpg') }}" alt="{{ $item->title }}" width="78" height="64" class="rounded" style="object-fit:cover; flex-shrink:0;">
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size:.88rem; line-height:1.3;">{{ $item->title }}</div>
                                    <div class="text-muted-2 mt-1" style="font-size:.72rem;">{{ optional($item->published_at ?? $item->created_at)->format('d M Y') }}</div>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted-2 small mb-0">More stories are on the way.</p>
                        @endforelse
                    </div>

                </aside>
            </div>
        </div>
    </section>
@endsection
