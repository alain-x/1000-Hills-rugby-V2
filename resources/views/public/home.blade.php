@extends('public.layout')

@section('title', setting('hero_title') ?: '1000 Hills Rugby | Rugby for life in Kigali, Rwanda')
@section('meta_description', setting('meta_description') ?: 'Official website of 1000 Hills Rugby. Follow our teams, fixtures, results, news and community programmes in Kigali, Rwanda.')

@section('content')
    <section class="hero" style="background-image: url('{{ media_url(setting('hero_image'), 'uploads/1740072895_fans.JPG') }}');">
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge"><i class="bi bi-shield-fill"></i> Kigali, Rwanda · Est. {{ setting('founded_year', 2014) }}</span>
                <h1>{{ setting('hero_title', 'Building champions. Inspiring a community.') }}</h1>
                <p>{{ setting('hero_subtitle', '1000 Hills Rugby develops young people through the power of rugby, education and opportunity — on and off the pitch.') }}</p>
                <div class="hero-actions">
                    <a href="{{ route('teams.index') }}" class="btn btn-gold btn-lg">Explore our teams <i class="bi bi-arrow-right ms-1"></i></a>
                    <a href="{{ route('donate') }}" class="btn btn-outline-light btn-lg">Support the club</a>
                </div>
            </div>
        </div>
        <span class="hero-scroll">Scroll to discover</span>
    </section>

    <div class="container quick-stats">
        <div class="row g-3">
            <div class="col-6 col-lg-3">
                <div class="stat-card d-flex align-items-start justify-content-between">
                    <div><div class="stat-value" data-counter="{{ $stats['teams'] }}">0</div><div class="stat-label">Squads competing</div></div>
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card d-flex align-items-start justify-content-between">
                    <div><div class="stat-value" data-counter="{{ $stats['players'] }}">0</div><div class="stat-label">Registered players</div></div>
                    <i class="bi bi-person-badge-fill"></i>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card d-flex align-items-start justify-content-between">
                    <div><div class="stat-value" data-counter="{{ $stats['years'] }}">0</div><div class="stat-label">Years of impact</div></div>
                    <i class="bi bi-award-fill"></i>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card d-flex align-items-start justify-content-between">
                    <div><div class="stat-value" data-counter="{{ $stats['articles'] }}">0</div><div class="stat-label">Stories published</div></div>
                    <i class="bi bi-journal-richtext"></i>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-8 reveal">
                    <span class="eyebrow">Latest from the club</span>
                    <h2 class="section-title">Stories from the heart of the hill</h2>
                    <p class="section-lead">Match reports, player milestones and community updates from across the 1000 Hills family.</p>
                </div>
                <div class="col-lg-4 text-lg-end reveal">
                    <a href="{{ route('news.index') }}" class="btn btn-outline-forest">All news <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>

            @if($featured)
                <div class="row g-4 mb-4">
                    <div class="col-lg-7 reveal">
                        <article class="feature-story" style="background-image: url('{{ media_url($featured->featured_image, 'uploads/NRC25/IMG_1906.JPG') }}');">
                            <div class="feature-body">
                                <span class="badge-category mb-3">{{ $featured->category }}</span>
                                <h2><a href="{{ route('news.show', $featured) }}" class="text-white">{{ $featured->title }}</a></h2>
                                <p class="mt-2 mb-3">{{ $featured->excerpt_text }}</p>
                                <div class="meta text-white-50 mb-3">
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ optional($featured->published_at ?? $featured->created_at)->format('d M Y') }}</span>
                                    <span><i class="bi bi-clock me-1"></i>{{ $featured->reading_time }} min read</span>
                                </div>
                                <a href="{{ route('news.show', $featured) }}" class="btn btn-gold btn-sm">Read the full story</a>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-5">
                        <div class="row g-3">
                            @foreach($articles as $article)
                                <div class="col-12 reveal">
                                    <article class="news-card card-clean">
                                        <div class="row g-0">
                                            <div class="col-4">
                                                <div class="news-media h-100" style="aspect-ratio:auto;">
                                                    <img src="{{ media_url($article->featured_image, 'images/rugby-2.jpg') }}" alt="{{ $article->title }}" loading="lazy">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="news-body p-3">
                                                    <span class="badge-category">{{ $article->category }}</span>
                                                    <h3 class="fs-6 mt-2 mb-1"><a href="{{ route('news.show', $article) }}">{{ $article->title }}</a></h3>
                                                    <div class="meta"><span><i class="bi bi-calendar3 me-1"></i>{{ optional($article->published_at ?? $article->created_at)->format('d M Y') }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state card-clean"><i class="bi bi-journal-x"></i>News stories will appear here soon.</div>
            @endif
        </div>
    </section>

    <section class="section bg-cream">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5 reveal">
                    <span class="eyebrow">Match centre</span>
                    <h2 class="section-title">The next chapter on the pitch</h2>
                    <p class="section-lead mb-4">Follow the first team, women's side and academy squads through every fixture and result.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('fixtures.index') }}" class="btn btn-forest">Full fixture list</a>
                        <a href="{{ route('tables.index') }}" class="btn btn-outline-forest">League tables</a>
                    </div>
                    @if($event)
                        <div class="card-clean h-auto mt-4 p-3">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="text-center" style="min-width:64px;">
                                    <span class="d-block display-font fw-bold text-forest" style="font-size:1.8rem; line-height:1;">{{ $event->event_date->format('d') }}</span>
                                    <span class="d-block text-uppercase text-muted-2" style="font-size:.68rem; letter-spacing:.1em;">{{ $event->event_date->format('M') }}</span>
                                </div>
                                <div>
                                    <span class="badge-category">{{ $event->frequency }}</span>
                                    <h3 class="fs-6 mt-2 mb-1"><a href="{{ route('events.show', $event) }}" class="text-dark">{{ $event->title }}</a></h3>
                                    <div class="meta"><span><i class="bi bi-geo-alt me-1"></i>{{ $event->location }}</span></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-md-6 reveal">
                            <div class="match-card">
                                <div class="match-label"><i class="bi bi-lightning-charge-fill me-1"></i>Next fixture</div>
                                @if($upcoming->first())
                                    @php($next = $upcoming->first())
                                    <div class="match-teams">
                                        <div class="match-team">
                                            <img src="{{ media_url($next->home_logo, 'images/1000-hills-logo.png') }}" alt="{{ $next->home_team }}">
                                            <span class="name">{{ $next->home_team }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="match-vs">VS</span>
                                            <div class="mt-1 text-white-50" style="font-size:.72rem;">{{ optional($next->match_date)->format('d M · H:i') }}</div>
                                        </div>
                                        <div class="match-team">
                                            <img src="{{ media_url($next->away_logo, 'images/placeholder.svg') }}" alt="{{ $next->away_team }}">
                                            <span class="name">{{ $next->away_team }}</span>
                                        </div>
                                    </div>
                                    <div class="match-meta d-flex justify-content-between">
                                        <span><i class="bi bi-trophy me-1"></i>{{ $next->competition ?: 'Club fixture' }}</span>
                                        <span><i class="bi bi-geo-alt me-1"></i>{{ $next->stadium ?: 'TBC' }}</span>
                                    </div>
                                @else
                                    <p class="text-white-50 mt-4 mb-0">The next fixture will be announced soon.</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 reveal">
                            <div class="card-clean h-100 p-3">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="fs-6 mb-0"><i class="bi bi-check2-circle text-gold me-2"></i>Recent results</h3>
                                    <a href="{{ route('fixtures.index') }}" class="small">All results</a>
                                </div>
                                @forelse($results as $result)
                                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom {{ $loop->last ? 'border-0 pb-0' : '' }}">
                                        <div style="min-width:0;">
                                            <div class="text-truncate" style="font-size:.88rem; font-weight:600;">{{ $result->home_team }} <span class="text-muted-2">v</span> {{ $result->away_team }}</div>
                                            <div class="text-muted-2" style="font-size:.72rem;">{{ optional($result->match_date)->format('d M Y') }} · {{ $result->competition ?: 'Friendly' }}</div>
                                        </div>
                                        <span class="fixture-score ms-2">{{ $result->home_score }}–{{ $result->away_score }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted-2 mb-0 small">No completed matches recorded yet.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-12 reveal">
                            <div class="card-clean p-3">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h3 class="fs-6 mb-0"><i class="bi bi-calendar-week text-gold me-2"></i>This week at the club</h3>
                                    <a href="{{ route('events.index') }}" class="small">Full schedule</a>
                                </div>
                                @forelse($schedule as $slot)
                                    <div class="week-slot d-flex align-items-center gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <span class="fixture-status" style="min-width:92px; text-align:center;">{{ $slot->day }}</span>
                                        <div class="flex-grow-1" style="min-width:0;">
                                            <div style="font-size:.88rem; font-weight:600;">{{ $slot->activity }}</div>
                                            <div class="text-muted-2" style="font-size:.74rem;"><i class="bi bi-geo-alt me-1"></i>{{ $slot->location }}</div>
                                        </div>
                                        <span class="week-time text-forest fw-bold" style="font-size:.78rem;">{{ $slot->time_range }}</span>
                                    </div>
                                @empty
                                    <p class="text-muted-2 mb-0 small">Training schedule will be published soon.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="eyebrow">One club, many pathways</span>
                <h2 class="section-title">Our squads</h2>
                <p class="section-lead mx-auto">From grassroots rugby to senior competition, every player has a place to grow at 1000 Hills.</p>
            </div>
            <div class="row g-3">
                @foreach($teams as $team)
                    <div class="col-6 col-md-4 col-lg-4 reveal">
                        <a href="{{ route('teams.show', $team) }}" class="text-decoration-none">
                            <div class="card-clean team-card">
                                <div class="team-crest">
                                    <img src="{{ media_url($team->logo, 'images/1000-hills-logo.png') }}" alt="{{ $team->name }}">
                                </div>
                                <h3>{{ $team->name }}</h3>
                                <div class="team-meta">{{ $team->age_group ?: ($team->gender ?: 'Senior') }}</div>
                                <span class="team-count">{{ $team->players()->where('is_published', true)->count() }} players</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section bg-forest">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 reveal">
                    <span class="eyebrow">More than a game</span>
                    <h2 class="section-title">Rugby is the starting point. Opportunity is the goal.</h2>
                    <p class="section-lead">Through our academy, education and community programmes, we help young people build the skills, confidence and connections to thrive beyond the pitch.</p>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a href="{{ route('pages.show', 'about') }}" class="btn btn-gold">Our story</a>
                        <a href="{{ route('pages.show', 'foundation') }}" class="btn btn-outline-light">The foundation</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        @foreach([
                            ['icon' => 'bi-mortarboard-fill', 'title' => 'Education support', 'text' => 'Tutoring, school fees and mentorship for players who need a lift.'],
                            ['icon' => 'bi-people-fill', 'title' => 'Community first', 'text' => 'Family engagement and outreach that strengthens our neighbourhoods.'],
                            ['icon' => 'bi-heart-pulse-fill', 'title' => 'Player wellbeing', 'text' => 'Safeguarding, nutrition and a safe place to belong.'],
                        ] as $item)
                            <div class="col-12 reveal">
                                <div class="d-flex gap-3 p-3 rounded-xl" style="background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);">
                                    <div class="flex-shrink-0" style="width:44px; height:44px; display:grid; place-items:center; border-radius:12px; background: rgba(227,178,60,.15); color: var(--hr-gold);"><i class="bi {{ $item['icon'] }}"></i></div>
                                    <div><h4 class="fs-6 mb-1">{{ $item['title'] }}</h4><p class="mb-0 small text-white-50">{{ $item['text'] }}</p></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 align-items-end mb-4">
                <div class="col-lg-8 reveal">
                    <span class="eyebrow">Our partners</span>
                    <h2 class="section-title">Powered by people who believe in the journey</h2>
                </div>
                <div class="col-lg-4 text-lg-end reveal">
                    <a href="{{ route('sponsors.index') }}" class="btn btn-outline-forest">Become a partner</a>
                </div>
            </div>
            <div class="row g-3 align-items-center">
                @forelse($sponsors as $sponsor)
                    <div class="col-6 col-md-3 col-lg-2 reveal">
                        <div class="card-clean d-flex align-items-center justify-content-center p-3" style="min-height:104px;">
                            <img src="{{ media_url($sponsor->logo_path, 'images/LSFG+PartnerLogos-Colour-horizontal.jpg') }}" alt="{{ $sponsor->name ?: 'Partner' }}" style="max-height:58px; width:auto; object-fit:contain; filter:grayscale(20%);">
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-muted-2">Partner logos will be published soon.</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
