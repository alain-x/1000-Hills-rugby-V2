@extends('public.layout')

@section('title', $event->title.' | 1000 Hills Rugby Events')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($event->description), 155))
@section('og_image', media_url($event->image, 'images/events-bg.jpg'))

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url($event->image, 'images/events-bg.jpg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                    <li class="breadcrumb-item active">{{ $event->frequency }}</li>
                </ol>
            </nav>
            <span class="badge-category mb-3">{{ $event->frequency }}</span>
            <h1>{{ $event->title }}</h1>
            <div class="meta text-white-50 mt-3">
                <span><i class="bi bi-calendar3 me-1"></i>{{ $event->event_date->format('l, d F Y') }}</span>
                @if($event->event_time)<span><i class="bi bi-clock me-1"></i>{{ $event->event_time }}</span>@endif
                <span><i class="bi bi-geo-alt me-1"></i>{{ $event->location ?: 'Kigali, Rwanda' }}</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="article-body">
                        {!! $event->description ?: '<p>More details about this event will be shared soon.</p>' !!}
                    </div>

                    @if($event->image)
                        <div class="prose-hero mt-4"><img src="{{ media_url($event->image) }}" alt="{{ $event->title }}"></div>
                    @endif
                </div>
                <aside class="col-lg-4">
                    <div class="card-clean p-4 mb-4">
                        <h3 class="fs-5 mb-3">Event details</h3>
                        <ul class="list-clean">
                            <li class="d-flex gap-3 py-2 border-bottom"><i class="bi bi-calendar3 text-gold"></i><div><div class="text-muted-2 small">Date</div><div class="fw-semibold">{{ $event->event_date->format('d F Y') }}</div></div></li>
                            @if($event->event_time)<li class="d-flex gap-3 py-2 border-bottom"><i class="bi bi-clock text-gold"></i><div><div class="text-muted-2 small">Time</div><div class="fw-semibold">{{ $event->event_time }}</div></div></li>@endif
                            <li class="d-flex gap-3 py-2 border-bottom"><i class="bi bi-geo-alt text-gold"></i><div><div class="text-muted-2 small">Location</div><div class="fw-semibold">{{ $event->location ?: 'To be confirmed' }}</div></div></li>
                            @if($event->participants)<li class="d-flex gap-3 py-2"><i class="bi bi-people text-gold"></i><div><div class="text-muted-2 small">Who it's for</div><div class="fw-semibold">{{ $event->participants }}</div></div></li>@endif
                        </ul>
                        <a href="{{ route('contact.create') }}" class="btn btn-forest w-100 mt-3">Get in touch</a>
                    </div>

                    <div class="match-card">
                        <div class="match-label">Be part of it</div>
                        <h3 class="text-white mt-2" style="font-size:1.3rem;">Help us create more moments like this.</h3>
                        <p class="text-white-50 small mb-3">Your support keeps our programmes running all year round.</p>
                        <a href="{{ route('donate') }}" class="btn btn-gold btn-sm">Support the club</a>
                    </div>
                </aside>
            </div>

            @if($others->count())
                <hr class="my-5">
                <div class="d-flex align-items-end justify-content-between mb-4">
                    <div><span class="eyebrow">Also coming up</span><h2 class="section-title mb-0">More events</h2></div>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-forest btn-sm">All events</a>
                </div>
                <div class="row g-4">
                    @foreach($others as $item)
                        <div class="col-md-4">
                            <article class="card-clean h-100">
                                <div class="news-media"><img src="{{ media_url($item->image, 'images/events-bg.jpg') }}" alt="{{ $item->title }}" loading="lazy"></div>
                                <div class="news-body">
                                    <span class="badge-category">{{ $item->frequency }}</span>
                                    <h3 class="fs-6 mt-2"><a href="{{ route('events.show', $item) }}">{{ $item->title }}</a></h3>
                                    <div class="meta"><span><i class="bi bi-calendar3 me-1"></i>{{ $item->event_date->format('d M Y') }}</span></div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
