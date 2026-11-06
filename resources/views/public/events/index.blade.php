@extends('public.layout')

@section('title', 'Events & weekly schedule | 1000 Hills Rugby')
@section('meta_description', 'Upcoming events, tournaments and the weekly training schedule at 1000 Hills Rugby in Kigali.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ asset('images/events-bg.jpg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Events</li></ol>
            </nav>
            <h1>Events &amp; the club calendar</h1>
            <p>Tournaments, community days and the weekly rhythm of training at 1000 Hills Rugby.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-8">
                    <span class="eyebrow">What's coming up</span>
                    <h2 class="section-title mb-0">Upcoming events</h2>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#weekly-schedule" class="btn btn-outline-forest"><i class="bi bi-calendar-week me-1"></i>Weekly schedule</a>
                </div>
            </div>

            <div class="row g-4">
                @forelse($upcoming as $event)
                    <div class="col-md-6 col-lg-4 reveal">
                        <article class="card-clean h-100">
                            <div class="news-media">
                                <img src="{{ media_url($event->image, 'images/events-bg.jpg') }}" alt="{{ $event->title }}" loading="lazy">
                            </div>
                            <div class="news-body">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <span class="badge-category">{{ $event->frequency }}</span>
                                    @if($event->participants)<span class="text-muted-2 small">{{ $event->participants }}</span>@endif
                                </div>
                                <h3 class="fs-5"><a href="{{ route('events.show', $event) }}">{{ $event->title }}</a></h3>
                                <div class="meta mt-2 mb-3">
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ $event->event_date->format('d M Y') }}</span>
                                    @if($event->event_time)<span><i class="bi bi-clock me-1"></i>{{ $event->event_time }}</span>@endif
                                </div>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($event->description), 120) }}</p>
                                <a href="{{ route('events.show', $event) }}" class="btn btn-outline-forest btn-sm mt-2">Event details</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12"><div class="empty-state card-clean"><i class="bi bi-calendar-x"></i>No upcoming events are scheduled. Check back soon.</div></div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">{{ $upcoming->links() }}</div>
        </div>
    </section>

    <section class="section bg-cream" id="weekly-schedule">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <span class="eyebrow">Every week</span>
                    <h2 class="section-title">Training schedule</h2>
                    <p class="section-lead">Sessions are open to registered players. New players are welcome to come along and try a session.</p>
                    <a href="{{ route('contact.create') }}" class="btn btn-forest mt-2">Ask about joining</a>
                </div>
                <div class="col-lg-7">
                    <div class="schedule-list">
                        @forelse($schedule as $slot)
                            <div class="schedule-row">
                                <div class="day">{{ $slot->day }}</div>
                                <div>
                                    <div class="activity">{{ $slot->activity }}</div>
                                    <div class="where"><i class="bi bi-geo-alt me-1"></i>{{ $slot->location }}</div>
                                </div>
                                <div class="time">{{ $slot->time_range }}</div>
                            </div>
                        @empty
                            <div class="p-4 text-muted-2">The training schedule will be published soon.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                <div>
                    <span class="eyebrow">Looking back</span>
                    <h2 class="section-title mb-0">Past events</h2>
                </div>
            </div>
            <div class="row g-3">
                @forelse($past as $event)
                    <div class="col-md-6">
                        <a href="{{ route('events.show', $event) }}" class="fixture-row text-decoration-none h-100">
                            <div class="fixture-date">
                                <span class="d">{{ $event->event_date->format('d') }}</span>
                                <span class="m">{{ $event->event_date->format('M Y') }}</span>
                            </div>
                            <div class="fixture-teams">
                                <div class="text-dark">{{ $event->title }}</div>
                                <div class="text-muted-2 fw-normal" style="font-size:.76rem;"><i class="bi bi-geo-alt me-1"></i>{{ $event->location ?: 'Kigali' }}</div>
                            </div>
                            <i class="bi bi-arrow-right text-forest"></i>
                        </a>
                    </div>
                @empty
                    <div class="col-12"><p class="text-muted-2">Past event highlights will appear here.</p></div>
                @endforelse
            </div>
            <div class="mt-4 d-flex justify-content-center">{{ $past->links() }}</div>
        </div>
    </section>
@endsection
