@extends('public.layout')

@section('title', 'Fixtures & results | 1000 Hills Rugby')
@section('meta_description', 'Fixtures, kick-off times and results for all 1000 Hills Rugby teams across the season.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url('uploads/1740072895_1hr_vs_Lions.jpeg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Fixtures</li></ol>
            </nav>
            <h1>Fixtures &amp; results</h1>
            <p>Follow every match across our senior and academy squads. Filter by season, competition or team.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <form action="{{ route('fixtures.index') }}" method="GET" class="filter-bar mb-4">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Season</label>
                        <select name="season" class="form-select">
                            @foreach($seasons as $item)
                                <option value="{{ $item }}" @selected((int) $season === (int) $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Competition</label>
                        <select name="competition" class="form-select">
                            <option value="">All competitions</option>
                            @foreach($competitions as $item)
                                <option value="{{ $item }}" @selected($competition === $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Squad</label>
                        <select name="gender" class="form-select">
                            <option value="">All squads</option>
                            <option value="MEN" @selected($gender === 'MEN')>Men</option>
                            <option value="WOMEN" @selected($gender === 'WOMEN')>Women</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-forest w-100" type="submit">Filter</button>
                        <a href="{{ route('fixtures.index') }}" class="btn btn-outline-forest" aria-label="Reset filters"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                </div>
            </form>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div><span class="eyebrow mb-1">Up next</span><h2 class="section-title fs-3 mb-0">Upcoming fixtures</h2></div>
                        <span class="badge-soft">{{ $upcoming->count() }}</span>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        @forelse($upcoming as $fixture)
                            <div class="card-clean p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge-category">{{ $fixture->competition ?: 'Friendly' }}</span>
                                    <span class="text-muted-2 small"><i class="bi bi-calendar3 me-1"></i>{{ optional($fixture->match_date)->format('d M Y') ?: 'TBC' }}</span>
                                </div>
                                <div class="match-teams" style="color: var(--hr-ink);">
                                    <div class="match-team">
                                        <img src="{{ media_url($fixture->home_logo, 'images/1000-hills-logo.png') }}" alt="{{ $fixture->home_team }}" style="background: var(--hr-cream);">
                                        <span class="name">{{ $fixture->home_team }}</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="match-vs text-muted-2">VS</div>
                                        <div class="fw-bold text-forest mt-1">{{ $fixture->match_time ?: (optional($fixture->match_date)->format('H:i') ?: 'TBC') }}</div>
                                    </div>
                                    <div class="match-team">
                                        <img src="{{ media_url($fixture->away_logo, 'images/placeholder.svg') }}" alt="{{ $fixture->away_team }}" style="background: var(--hr-cream);">
                                        <span class="name">{{ $fixture->away_team }}</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between text-muted-2 small border-top pt-2 mt-2">
                                    <span><i class="bi bi-geo-alt me-1"></i>{{ $fixture->stadium ?: 'Venue TBC' }}</span>
                                    <span>{{ $fixture->gender ?: 'Club' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state card-clean"><i class="bi bi-calendar-x"></i>No upcoming fixtures match these filters.</div>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div><span class="eyebrow mb-1">Recent form</span><h2 class="section-title fs-3 mb-0">Results</h2></div>
                        <span class="badge-soft">{{ $results->count() }} matches</span>
                    </div>
                    <div class="table-card">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Match</th>
                                        <th class="text-center">Score</th>
                                        <th>Competition</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($results as $fixture)
                                        <tr>
                                            <td class="text-muted-2" style="white-space:nowrap;">{{ optional($fixture->match_date)->format('d M Y') }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $fixture->home_team }}</div>
                                                <div class="text-muted-2 small">v {{ $fixture->away_team }}</div>
                                            </td>
                                            <td class="text-center"><span class="fw-bold text-forest">{{ $fixture->home_score }}–{{ $fixture->away_score }}</span></td>
                                            <td class="text-muted-2 small">{{ $fixture->competition ?: 'Friendly' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted-2 py-4">No results recorded for these filters.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
