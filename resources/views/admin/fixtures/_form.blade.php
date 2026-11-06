@php($isEdit = $fixture->exists)
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Match details</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="home_team">Home team <span class="text-danger">*</span></label>
                        <input type="text" id="home_team" name="home_team" value="{{ old('home_team', $fixture->home_team) }}" class="form-control @error('home_team') is-invalid @enderror" required>
                        @error('home_team')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="away_team">Away team <span class="text-danger">*</span></label>
                        <input type="text" id="away_team" name="away_team" value="{{ old('away_team', $fixture->away_team) }}" class="form-control @error('away_team') is-invalid @enderror" required>
                        @error('away_team')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="match_date">Match date</label>
                        <input type="datetime-local" id="match_date" name="match_date" value="{{ old('match_date', optional($fixture->match_date)->format('Y-m-d\TH:i')) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="match_time">Kick-off note</label>
                        <input type="text" id="match_time" name="match_time" value="{{ old('match_time', $fixture->match_time) }}" class="form-control" placeholder="e.g. 15:00">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="season">Season</label>
                        <input type="number" id="season" name="season" value="{{ old('season', $fixture->season ?? current_season()) }}" min="1990" max="2100" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="competition">Competition</label>
                        <input type="text" id="competition" name="competition" value="{{ old('competition', $fixture->competition) }}" class="form-control" placeholder="e.g. Rwanda Premier League">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="gender">Squad</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="">Not specified</option>
                            <option value="MEN" @selected(old('gender', $fixture->gender) === 'MEN')>Men</option>
                            <option value="WOMEN" @selected(old('gender', $fixture->gender) === 'WOMEN')>Women</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="stadium">Stadium / venue</label>
                        <input type="text" id="stadium" name="stadium" value="{{ old('stadium', $fixture->stadium) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select" required>
                            @foreach(['SCHEDULED', 'COMPLETED', 'CANCELLED', 'POSTPONED'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $fixture->status) === $status)>{{ ucfirst(strtolower($status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="home_score">Home score</label>
                        <input type="number" id="home_score" name="home_score" value="{{ old('home_score', $fixture->home_score ?? 0) }}" min="0" max="999" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="away_score">Away score</label>
                        <input type="number" id="away_score" name="away_score" value="{{ old('away_score', $fixture->away_score ?? 0) }}" min="0" max="999" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="notes">Match notes</label>
                        <textarea id="notes" name="notes" rows="4" class="form-control">{{ old('notes', $fixture->notes) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Publishing</h5></div>
            <div class="card-panel-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" @checked(old('is_published', $fixture->is_published ?? true))>
                    <label class="form-check-label" for="is_published">Show on fixtures page</label>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Create fixture' }}</button>
                    <a href="{{ route('admin.fixtures.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Home team logo</h5></div>
            <div class="card-panel-body">
                @if($fixture->home_logo)
                    <img src="{{ media_url($fixture->home_logo) }}" alt="" class="w-100 rounded mb-2 bg-light p-2" style="height:100px;object-fit:contain;">
                @endif
                <input type="file" name="home_logo" class="form-control" accept="image/*" data-preview="#homeLogoPreview">
                <img id="homeLogoPreview" class="w-100 rounded mt-2 d-none bg-light p-2" alt="Preview" style="height:100px;object-fit:contain;">
            </div>
        </div>
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Away team logo</h5></div>
            <div class="card-panel-body">
                @if($fixture->away_logo)
                    <img src="{{ media_url($fixture->away_logo) }}" alt="" class="w-100 rounded mb-2 bg-light p-2" style="height:100px;object-fit:contain;">
                @endif
                <input type="file" name="away_logo" class="form-control" accept="image/*" data-preview="#awayLogoPreview">
                <img id="awayLogoPreview" class="w-100 rounded mt-2 d-none bg-light p-2" alt="Preview" style="height:100px;object-fit:contain;">
            </div>
        </div>
    </div>
</div>
