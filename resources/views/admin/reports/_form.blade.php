<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Player and squad</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    @if(auth()->user()->isCoach())
                        <input type="hidden" name="team_id" value="{{ $team?->id }}">
                        <div class="col-md-6">
                            <label class="form-label">Squad</label>
                            <input type="text" class="form-control" value="{{ $team?->name }}" readonly>
                        </div>
                    @else
                        <div class="col-md-6">
                            <label class="form-label" for="team_id">Squad</label>
                            <select id="team_id" name="team_id" class="form-select" required>
                                @foreach($teams as $item)
                                    <option value="{{ $item->id }}" @selected(old('team_id', $report->team_id) == $item->id)>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <label class="form-label" for="player_id">Player <span class="text-danger">*</span></label>
                        <select id="player_id" name="player_id" class="form-select" required>
                            <option value="">Choose a player</option>
                            @foreach($players as $player)
                                <option value="{{ $player->id }}" @selected(old('player_id', $report->player_id) == $player->id)>{{ $player->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="report_date">Date <span class="text-danger">*</span></label>
                        <input type="date" id="report_date" name="report_date" value="{{ old('report_date', optional($report->report_date)->toDateString()) }}" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Coach report</h5></div>
            <div class="card-panel-body">
                <label class="form-label" for="report">Written report <span class="text-danger">*</span></label>
                <textarea id="report" name="report" rows="8" class="form-control" required minlength="20" placeholder="What did the player do well, and what should they work on?">{{ old('report', $report->report) }}</textarea>
                <div class="form-text">At least a short paragraph. This is visible to club administrators.</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Performance rating</h5></div>
            <div class="card-panel-body">
                <p class="text-muted small">Score each area from 1 (needs work) to 5 (excellent). The overall rating is the average.</p>
                @foreach(\App\Models\PlayerReport::SCORES as $field => $label)
                    <div class="mb-3">
                        <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                        <select id="{{ $field }}" name="{{ $field }}" class="form-select" required>
                            @for($score = 1; $score <= 5; $score++)
                                <option value="{{ $score }}" @selected((int) old($field, $report->{$field}) === $score)>{{ $score }}</option>
                            @endfor
                        </select>
                    </div>
                @endforeach
                <button class="btn btn-admin-forest w-100" type="submit"><i class="bi bi-check2 me-1"></i>{{ $report->exists ? 'Update report' : 'Save report' }}</button>
            </div>
        </div>
    </div>
</div>
