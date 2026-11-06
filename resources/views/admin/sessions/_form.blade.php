@php
    $session = $session ?? null;
@endphp

<div class="card-panel">
    <div class="card-panel-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Squad</label>
                <select name="team_id" class="form-select" required>
                    @foreach($teams as $item)
                        <option value="{{ $item->id }}" @selected(old('team_id', $session->team_id) == $item->id)>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $session->title) }}" placeholder="Tuesday contact session" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Type</label>
                <select name="session_type" class="form-select" required>
                    @foreach(\App\Models\SquadSession::TYPES as $value => $label)
                        <option value="{{ $value }}" @selected(old('session_type', $session->session_type) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Focus</label>
                <select name="focus" class="form-select">
                    @foreach(\App\Models\SquadSession::FOCUSES as $value => $label)
                        <option value="{{ $value }}" @selected(old('focus', $session->focus) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Intensity</label>
                <select name="intensity" class="form-select" required>
                    @foreach(\App\Models\SquadSession::INTENSITIES as $value => $label)
                        <option value="{{ $value }}" @selected(old('intensity', $session->intensity) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Starts</label>
                <input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at', optional($session->starts_at)->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Duration (minutes)</label>
                <input type="number" name="duration_minutes" class="form-control" min="15" max="240" value="{{ old('duration_minutes', $session->duration_minutes) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    @foreach(\App\Models\SquadSession::STATUSES as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $session->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $session->location) }}" placeholder="Training pitch">
            </div>
            <div class="col-md-6">
                <label class="form-label">Opponent</label>
                <input type="text" name="opponent" class="form-control" value="{{ old('opponent', $session->opponent) }}" placeholder="For matches">
            </div>
            <div class="col-12">
                <label class="form-label">Session plan</label>
                <textarea name="plan" class="form-control" rows="4" placeholder="Warm-up, unit work, opposed session, cool-down">{{ old('plan', $session->plan) }}</textarea>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-admin-forest" type="submit">Save session</button>
            <a href="{{ route('admin.sessions.index') }}" class="btn btn-admin-outline">Cancel</a>
        </div>
    </div>
</div>
