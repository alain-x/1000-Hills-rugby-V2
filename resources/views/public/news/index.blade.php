@extends('public.layout')

@section('title', $category ? $category.' news | 1000 Hills Rugby' : 'News | 1000 Hills Rugby')
@section('meta_description', 'The latest news, match reports and club stories from 1000 Hills Rugby in Kigali, Rwanda.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url('images/rugby-2.jpg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">News</li></ol>
            </nav>
            <h1>News &amp; stories</h1>
            <p>Match reports, player milestones, academy updates and the people behind 1000 Hills Rugby.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="eyebrow">From the club</span>
                    <h2 class="section-title mb-0">{{ $search ? 'Search results' : ($category ?: 'All stories') }}</h2>
                    @if($search)
                        <p class="text-muted-2 mb-0 mt-2">Showing results for “{{ $search }}”.</p>
                    @endif
                </div>
                <div class="col-lg-5">
                    <form action="{{ route('news.index') }}" method="GET" class="filter-bar d-flex gap-2">
                        @if($category)<input type="hidden" name="category" value="{{ $category }}">@endif
                        <input type="search" name="q" value="{{ $search }}" class="form-control" placeholder="Search news..." aria-label="Search news">
                        <button class="btn btn-forest" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('news.index') }}" class="btn btn-sm {{ ! $category ? 'btn-forest' : 'btn-outline-forest' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('news.index', ['category' => $cat]) }}" class="btn btn-sm {{ $category === $cat ? 'btn-forest' : 'btn-outline-forest' }}">{{ $cat }}</a>
                @endforeach
            </div>

            <div class="row g-4">
                @forelse($articles as $article)
                    <div class="col-md-6 col-lg-4 reveal">
                        <article class="news-card card-clean">
                            <div class="news-media">
                                <a href="{{ route('news.show', $article) }}">
                                    <img src="{{ media_url($article->featured_image, 'uploads/NRC25/IMG_1906.JPG') }}" alt="{{ $article->title }}" loading="lazy">
                                </a>
                            </div>
                            <div class="news-body">
                                <span class="badge-category">{{ $article->category }}</span>
                                <h3><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></h3>
                                <p>{{ $article->excerpt_text }}</p>
                                <div class="meta mt-3">
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ optional($article->published_at ?? $article->created_at)->format('d M Y') }}</span>
                                    <span><i class="bi bi-clock me-1"></i>{{ $article->reading_time }} min read</span>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state card-clean">
                            <i class="bi bi-journal-x"></i>
                            <h3 class="fs-5">No stories found</h3>
                            <p class="mb-0">Try a different category or search term.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $articles->links() }}
            </div>
        </div>
    </section>
@endsection
