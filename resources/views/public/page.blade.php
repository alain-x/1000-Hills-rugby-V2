@extends('public.layout')

@section('title', ($page->meta_title ?: $page->title).' | 1000 Hills Rugby')
@section('meta_description', $page->meta_description ?: ($page->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($page->body), 155)))
@section('og_image', media_url($page->hero_image, 'images/rugby-2.jpg'))

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url($page->hero_image, 'images/rugby-2.jpg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">{{ $page->title }}</li></ol>
            </nav>
            <h1>{{ $page->title }}</h1>
            @if($page->subtitle)<p>{{ $page->subtitle }}</p>@endif
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    @if($page->hero_image)
                        <div class="prose-hero mb-4"><img src="{{ media_url($page->hero_image) }}" alt="{{ $page->title }}"></div>
                    @endif

                    @if($page->excerpt)
                        <p class="fs-5 text-forest mb-4" style="font-family:Georgia,serif;">{{ $page->excerpt }}</p>
                    @endif

                    <div class="article-body">
                        {!! $page->body !!}
                    </div>

                    @if($page->sections)
                        @foreach($page->sections as $section)
                            @if(! empty($section['title']) || ! empty($section['content']))
                                <div class="mt-5">
                                    @if(! empty($section['title']))<h2 class="section-title fs-3">{{ $section['title'] }}</h2>@endif
                                    @if(! empty($section['content']))<div class="article-body">{!! $section['content'] !!}</div>@endif
                                    @if(! empty($section['image']))<img src="{{ media_url($section['image']) }}" alt="{{ $section['title'] ?? $page->title }}" class="rounded-xl mt-3">@endif
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <aside class="col-lg-4">
                    <div class="card-clean p-4 mb-4">
                        <h3 class="fs-5 mb-3">Explore the club</h3>
                        <ul class="list-clean">
                            @foreach(['about' => 'Our story', 'academy' => 'Academy', 'foundation' => 'Foundation', 'community' => 'Community', 'education' => 'Education', 'privacy' => 'Privacy policy'] as $slug => $label)
                                @if($slug !== $page->slug)
                                    <li class="border-bottom"><a href="{{ route('pages.show', $slug) }}" class="d-flex align-items-center justify-content-between py-2"><span>{{ $label }}</span><i class="bi bi-arrow-right"></i></a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="involved-card">
                        <span class="involved-icon" aria-hidden="true"><i class="bi bi-people-fill"></i></span>
                        <span class="involved-eyebrow">Get involved</span>
                        <h3>There is a place for you at 1000 Hills.</h3>
                        <p class="involved-lead">Play, coach, volunteer or partner with us. Every contribution helps a young person grow through rugby.</p>
                        <ul class="involved-list">
                            <li>
                                <span class="involved-list-icon" aria-hidden="true"><i class="bi bi-shield-check"></i></span>
                                <span><strong>Join a squad</strong><small>From tag rugby to senior teams</small></span>
                            </li>
                            <li>
                                <span class="involved-list-icon" aria-hidden="true"><i class="bi bi-person-plus-fill"></i></span>
                                <span><strong>Coach or volunteer</strong><small>Share your time and experience</small></span>
                            </li>
                            <li>
                                <span class="involved-list-icon" aria-hidden="true"><i class="bi bi-briefcase-fill"></i></span>
                                <span><strong>Partner with us</strong><small>Support our community programmes</small></span>
                            </li>
                        </ul>
                        <a href="{{ route('contact.create') }}" class="btn btn-gold w-100">Contact the club <i class="bi bi-arrow-right ms-1"></i></a>
                        <a href="{{ route('donate') }}" class="involved-link">Or support the club <i class="bi bi-arrow-up-right"></i></a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
