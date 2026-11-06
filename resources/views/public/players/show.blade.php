@extends('public.layout')

@section('title', $player->name.' | 1000 Hills Rugby')
@section('meta_description', 'Player profile for '.$player->name.($team ? ', '.$team->name : '').' at 1000 Hills Rugby.')
@section('og_image', media_url($player->image, 'images/rugby-2.jpg'))

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url($player->image, 'images/rugby-2.jpg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">Teams</a></li>
                    @if($team)
                        <li class="breadcrumb-item"><a href="{{ route('teams.show', $team) }}">{{ $team->name }}</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $player->name }}</li>
                </ol>
            </nav>
            <span class="badge-category mb-3">{{ $player->position_category ?: 'Player' }}</span>
            <h1>{{ $player->name }}</h1>
            <p>{{ $player->role ?: ($team->name ?? '1000 Hills Rugby') }}@if($player->special_role) · {{ $player->special_role }}@endif</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card-clean overflow-hidden">
                        <div class="player-photo" style="aspect-ratio:4/4.4;">
                            @if($player->image)
                                <img src="{{ media_url($player->image) }}" alt="{{ $player->name }}">
                            @else
                                <span class="player-initials" style="font-size:5rem;">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($player->name, 0, 1)) }}</span>
                            @endif
                            @if($player->special_role)
                                <span class="player-role-tag">{{ $player->special_role }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="row text-center g-3">
                                <div class="col-4"><div class="fw-bold fs-4 text-forest">{{ $player->games }}</div><div class="text-muted-2 small">Appearances</div></div>
                                <div class="col-4"><div class="fw-bold fs-4 text-forest">{{ $player->tries }}</div><div class="text-muted-2 small">Tries</div></div>
                                <div class="col-4"><div class="fw-bold fs-4 text-forest">{{ $player->points }}</div><div class="text-muted-2 small">Points</div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card-clean p-4 h-100">
                        <h2 class="fs-4 mb-3">Player profile</h2>
                        <div class="row g-3">
                            @php
                                $profile = [
                                    'Team' => $team->name ?? '1000 Hills Rugby',
                                    'Position' => $player->role,
                                    'Category' => $player->position_category,
                                    'Age' => $player->age ? $player->age.' years' : null,
                                    'Date of birth' => optional($player->date_of_birth)->format('d F Y'),
                                    'Nationality' => $player->nationality,
                                    'Place of birth' => $player->place_of_birth,
                                    'Height' => $player->height,
                                    'Weight' => $player->weight,
                                    'Joined club' => $player->joined,
                                ];
                            @endphp
                            @foreach($profile as $label => $value)
                                @if($value)
                                    <div class="col-sm-6">
                                        <div class="text-muted-2 small text-uppercase" style="letter-spacing:.08em;">{{ $label }}</div>
                                        <div class="fw-semibold">{{ $value }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if($player->previous_clubs || $player->honours || $player->sponsor)
                            <hr class="my-4">
                            @if($player->previous_clubs)
                                <h3 class="fs-6">Previous clubs</h3>
                                <p class="text-muted-2">{{ $player->previous_clubs }}</p>
                            @endif
                            @if($player->honours)
                                <h3 class="fs-6 mt-3">Honours &amp; achievements</h3>
                                <p class="text-muted-2 mb-0">{{ $player->honours }}</p>
                            @endif
                            @if($player->sponsor)
                                <h3 class="fs-6 mt-3">Player sponsor</h3>
                                <p class="text-muted-2 mb-0"><strong class="text-dark">{{ $player->sponsor }}</strong>{{ $player->sponsor_desc ? ' — '.$player->sponsor_desc : '' }}</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            @if($team)
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="{{ route('teams.show', $team) }}" class="btn btn-forest"><i class="bi bi-arrow-left me-1"></i>Back to {{ $team->name }}</a>
                    <a href="{{ route('contact.create') }}" class="btn btn-outline-forest">Contact the club</a>
                </div>
            @endif

            @if($teamMates->count())
                <hr class="my-5">
                <div class="d-flex align-items-end justify-content-between mb-4">
                    <div><span class="eyebrow mb-1">Teammates</span><h2 class="section-title fs-3 mb-0">More from the squad</h2></div>
                    @if($team)<a href="{{ route('teams.show', $team) }}" class="btn btn-outline-forest btn-sm">Full squad</a>@endif
                </div>
                <div class="row g-3">
                    @foreach($teamMates as $mate)
                        <div class="col-6 col-md-4 col-lg-2">
                            @include('public.partials.player-card', ['player' => $mate])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
