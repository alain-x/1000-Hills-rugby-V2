@extends('public.layout')

@section('title', 'League tables | 1000 Hills Rugby')
@section('meta_description', 'Standings for the competitions 1000 Hills Rugby competes in, across men’s and women’s rugby.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ asset('images/league-table-banner.png') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Tables</li></ol>
            </nav>
            <h1>League tables</h1>
            <p>{{ $competition?->name ?? 'Competition' }} standings{{ $season?->year ? ' · '.$season->year.' season' : '' }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <form action="{{ route('tables.index') }}" method="GET" class="filter-bar mb-4">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Competition</label>
                        <select name="competition" class="form-select">
                            @foreach($competitions as $item)
                                <option value="{{ $item->id }}" @selected($competitionId === $item->id)>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Season</label>
                        <select name="season" class="form-select">
                            @foreach($seasons as $item)
                                <option value="{{ $item->id }}" @selected($seasonId === $item->id)>{{ $item->year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Squad</label>
                        <select name="gender" class="form-select">
                            @foreach($genders as $item)
                                <option value="{{ $item->id }}" @selected($genderId === $item->id)>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-forest w-100" type="submit">Update</button>
                    </div>
                </div>
            </form>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width:48px;">#</th>
                                <th>Club</th>
                                <th class="text-center">P</th>
                                <th class="text-center">W</th>
                                <th class="text-center">D</th>
                                <th class="text-center">L</th>
                                <th class="text-center d-none d-md-table-cell">PF</th>
                                <th class="text-center d-none d-md-table-cell">PA</th>
                                <th class="text-center">+/-</th>
                                <th class="text-center">Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($standings as $standing)
                                <tr>
                                    <td><span class="rank">{{ $loop->iteration }}</span></td>
                                    <td>
                                        <div class="club-cell">
                                            @if($standing->club->logo)
                                                <img src="{{ media_url($standing->club->logo) }}" alt="{{ $standing->club->name }}">
                                            @endif
                                            <span>{{ $standing->club->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $standing->matches_played }}</td>
                                    <td class="text-center">{{ $standing->matches_won }}</td>
                                    <td class="text-center">{{ $standing->matches_drawn }}</td>
                                    <td class="text-center">{{ $standing->matches_lost }}</td>
                                    <td class="text-center d-none d-md-table-cell">{{ $standing->points_for }}</td>
                                    <td class="text-center d-none d-md-table-cell">{{ $standing->points_against }}</td>
                                    <td class="text-center">{{ $standing->points_difference > 0 ? '+' : '' }}{{ $standing->points_difference }}</td>
                                    <td class="text-center points">{{ $standing->league_points }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="text-center text-muted-2 py-5">No standings are available for this selection.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3 justify-content-between mt-3 text-muted-2 small">
                <span><strong class="text-dark">P</strong> played · <strong class="text-dark">W</strong> won · <strong class="text-dark">D</strong> drawn · <strong class="text-dark">L</strong> lost · <strong class="text-dark">PF</strong> points for · <strong class="text-dark">PA</strong> points against · <strong class="text-dark">Pts</strong> league points</span>
                <a href="{{ route('fixtures.index') }}" class="fw-semibold">View fixtures <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </section>
@endsection
