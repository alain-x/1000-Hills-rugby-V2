@extends('public.layout')

@section('title', $team->name.' squad | 1000 Hills Rugby')
@section('meta_description', $team->description ?: 'Meet the '.$team->name.' squad at 1000 Hills Rugby.')
@section('og_image', media_url($team->cover_image, 'uploads/1740072895_1hr_Team.JPG'))

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url($team->cover_image, 'uploads/1740072895_1hr_Team.JPG') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">Teams</a></li>
                    <li class="breadcrumb-item active">{{ $team->name }}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="team-crest mb-0" style="background:rgba(255,255,255,.1); border-color:rgba(255,255,255,.2);">
                    <img src="{{ media_url($team->logo, 'images/1000-hills-logo.png') }}" alt="{{ $team->name }}">
                </div>
                <div>
                    <h1 class="mb-1">{{ $team->name }}</h1>
                    <p class="mb-0">{{ $team->age_group ?: ($team->gender ?: 'Senior squad') }}@if($team->coach) · Coach: {{ $team->coach }}@endif</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    @if($team->description)
                        <div class="article-body mb-4">{!! nl2br(e($team->description)) !!}</div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="card-clean p-3">
                        <div class="row text-center g-2">
                            <div class="col-4"><div class="fw-bold fs-4 text-forest">{{ $players->count() }}</div><div class="text-muted-2 small">Players</div></div>
                            <div class="col-4"><div class="fw-bold fs-4 text-forest">{{ $team->home_ground ? 'Home' : '—' }}</div><div class="text-muted-2 small">Ground</div></div>
                            <div class="col-4"><div class="fw-bold fs-4 text-forest">{{ $squadTeams->count() }}</div><div class="text-muted-2 small">Squads</div></div>
                        </div>
                        @if($team->home_ground)<div class="border-top mt-3 pt-2 text-muted-2 small"><i class="bi bi-geo-alt me-1"></i>{{ $team->home_ground }}</div>@endif
                    </div>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-end my-4">
                <div>
                    <span class="eyebrow mb-1">The squad</span>
                    <h2 class="section-title fs-3 mb-0">Meet the players</h2>
                </div>
                <form action="{{ route('teams.show', $team) }}" method="GET" class="d-flex gap-2">
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="search" name="q" value="{{ $search }}" class="form-control form-control-sm" placeholder="Search player or position" aria-label="Search squad">
                    <button class="btn btn-forest btn-sm" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-4">
                @foreach(['all' => 'All players', 'Forwards' => 'Forwards', 'Backs' => 'Backs', 'Captain' => 'Captain', 'Vice-Captain' => 'Vice-captain'] as $key => $label)
                    <a href="{{ route('teams.show', ['team' => $team, 'filter' => $key, 'q' => $search ?: null]) }}" class="btn btn-sm {{ $filter === $key ? 'btn-forest' : 'btn-outline-forest' }}">{{ $label }}</a>
                @endforeach
            </div>

            <div class="row g-3">
                @forelse($players as $player)
                    <div class="col-6 col-md-4 col-lg-3 reveal">
                        @include('public.partials.player-card', ['player' => $player])
                    </div>
                @empty
                    <div class="col-12"><div class="empty-state card-clean"><i class="bi bi-person-x"></i>No players match your search.</div></div>
                @endforelse
            </div>

            @if($squadTeams->where('id', '!=', $team->id)->count())
                <hr class="my-5">
                <div class="d-flex align-items-end justify-content-between mb-3">
                    <div><span class="eyebrow mb-1">Explore more</span><h2 class="section-title fs-3 mb-0">Other squads</h2></div>
                    <a href="{{ route('teams.index') }}" class="btn btn-outline-forest btn-sm">All teams</a>
                </div>
                <div class="row g-2">
                    @foreach($squadTeams->where('id', '!=', $team->id) as $other)
                        <div class="col-6 col-md-3">
                            <a href="{{ route('teams.show', $other) }}" class="fixture-row text-decoration-none">
                                <div class="team-crest mb-0" style="width:48px;height:48px;"><img src="{{ media_url($other->logo, 'images/1000-hills-logo.png') }}" alt="" style="width:38px;height:38px;"></div>
                                <div class="fixture-teams text-dark">{{ $other->name }}</div>
                                <i class="bi bi-arrow-right text-forest"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
