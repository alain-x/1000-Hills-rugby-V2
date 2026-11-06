@php($isEdit = $standing->exists)
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Table entry</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="club_id">Club <span class="text-danger">*</span></label>
                        <select id="club_id" name="club_id" class="form-select @error('club_id') is-invalid @enderror" required>
                            <option value="">Select a club</option>
                            @foreach($clubs as $club)
                                <option value="{{ $club->id }}" @selected((int) old('club_id', $standing->club_id) === $club->id)>{{ $club->name }}</option>
                            @endforeach
                        </select>
                        @error('club_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="competition_id">Competition <span class="text-danger">*</span></label>
                        <select id="competition_id" name="competition_id" class="form-select" required>
                            <option value="">Select a competition</option>
                            @foreach($competitions as $competition)
                                <option value="{{ $competition->id }}" @selected((int) old('competition_id', $standing->competition_id) === $competition->id)>{{ $competition->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="season_id">Season <span class="text-danger">*</span></label>
                        <select id="season_id" name="season_id" class="form-select" required>
                            <option value="">Select a season</option>
                            @foreach($seasons as $season)
                                <option value="{{ $season->id }}" @selected((int) old('season_id', $standing->season_id) === $season->id)>{{ $season->year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="gender_id">Gender <span class="text-danger">*</span></label>
                        <select id="gender_id" name="gender_id" class="form-select" required>
                            <option value="">Select a gender</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->id }}" @selected((int) old('gender_id', $standing->gender_id) === $gender->id)>{{ $gender->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Match statistics</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="matches_played">Played</label>
                        <input type="number" id="matches_played" name="matches_played" value="{{ old('matches_played', $standing->matches_played ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="matches_won">Won</label>
                        <input type="number" id="matches_won" name="matches_won" value="{{ old('matches_won', $standing->matches_won ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="matches_drawn">Drawn</label>
                        <input type="number" id="matches_drawn" name="matches_drawn" value="{{ old('matches_drawn', $standing->matches_drawn ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="matches_lost">Lost</label>
                        <input type="number" id="matches_lost" name="matches_lost" value="{{ old('matches_lost', $standing->matches_lost ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="tries_for">Tries for</label>
                        <input type="number" id="tries_for" name="tries_for" value="{{ old('tries_for', $standing->tries_for ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="tries_against">Tries against</label>
                        <input type="number" id="tries_against" name="tries_against" value="{{ old('tries_against', $standing->tries_against ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="points_for">Points for</label>
                        <input type="number" id="points_for" name="points_for" value="{{ old('points_for', $standing->points_for ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="points_against">Points against</label>
                        <input type="number" id="points_against" name="points_against" value="{{ old('points_against', $standing->points_against ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="league_points">League points</label>
                        <input type="number" id="league_points" name="league_points" value="{{ old('league_points', $standing->league_points ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="form_score">Form score</label>
                        <input type="number" id="form_score" name="form_score" value="{{ old('form_score', $standing->form_score ?? 0) }}" min="0" max="9.99" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="alert alert-light border w-100 mb-0 py-2 small"><i class="bi bi-info-circle me-1"></i>Points difference is calculated automatically.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Save</h5></div>
            <div class="card-panel-body">
                <p class="text-muted small">Each club can only appear once per competition, season and gender combination.</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Add standing' }}</button>
                    <a href="{{ route('admin.standings.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
