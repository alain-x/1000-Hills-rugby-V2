@extends('public.layout')

@section('title', 'Teams & squads | 1000 Hills Rugby')
@section('meta_description', 'Meet the men’s, women’s and academy squads of 1000 Hills Rugby in Kigali, Rwanda.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url('uploads/1740072895_1hr_Team.JPG') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Teams</li></ol>
            </nav>
            <h1>Teams &amp; squads</h1>
            <p>One club, one family. Browse our squads and get to know the players representing 1000 Hills.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-3">
                @forelse($teams as $team)
                    <div class="col-md-6 col-lg-4 reveal">
                        <article class="card-clean overflow-hidden h-100">
                            <div class="position-relative" style="height:190px; background:url('{{ media_url($team->cover_image, 'uploads/1740072895_1hr_Team.JPG') }}') center/cover;">
                                <div class="position-absolute inset-0" style="background:linear-gradient(0deg, rgba(4,37,28,.9) 0%, rgba(4,37,28,.25) 100%);"></div>
                                <div class="position-absolute bottom-0 start-0 p-3 d-flex align-items-center gap-3">
                                    <div class="team-crest mb-0" style="width:68px; height:68px;"><img src="{{ media_url($team->logo, 'images/1000-hills-logo.png') }}" alt="{{ $team->name }}" style="width:54px; height:54px;"></div>
                                    <div>
                                        <h2 class="text-white fs-4 mb-0">{{ $team->name }}</h2>
                                        <span class="text-white-50 small">{{ $team->age_group ?: ($team->category === 'women' ? 'Women' : 'Men') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                                <div class="text-muted-2 small"><i class="bi bi-people me-1"></i>{{ $team->players_count }} published players</div>
                                <a href="{{ route('teams.show', $team) }}" class="btn btn-outline-forest btn-sm">View squad <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                            @if($team->coach)
                                <div class="px-3 pb-3 text-muted-2 small"><i class="bi bi-award me-1"></i>Coach: {{ $team->coach }}</div>
                            @endif
                        </article>
                    </div>
                @empty
                    <div class="col-12"><div class="empty-state card-clean"><i class="bi bi-people"></i>Squad details will be published soon.</div></div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
