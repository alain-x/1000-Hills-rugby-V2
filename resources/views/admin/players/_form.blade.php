@php($isEdit = $player->exists)
@php($categories = [
    'men' => "Men's senior squad",
    'women' => "Women's senior squad",
    'academy_u18_boys' => 'U18 boys academy',
    'academy_u18_girls' => 'U18 girls academy',
    'academy_u16_boys' => 'U16 boys academy',
    'academy_u16_girls' => 'U16 girls academy',
])
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Player profile</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="name">Full name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $player->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="team_id">Linked team</label>
                        <select id="team_id" name="team_id" class="form-select">
                            <option value="">Not linked</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" @selected((int) old('team_id', $player->team_id) === $team->id)>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="team">Squad category <span class="text-danger">*</span></label>
                        <select id="team" name="team" class="form-select" required>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" @selected(old('team', $player->team) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Linking a team updates this automatically.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="position_category">Position group</label>
                        <select id="position_category" name="position_category" class="form-select">
                            <option value="">Not set</option>
                            @foreach(['Forwards', 'Backs'] as $position)
                                <option value="{{ $position }}" @selected(old('position_category', $player->position_category) === $position)>{{ $position }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="special_role">Squad role</label>
                        <select id="special_role" name="special_role" class="form-select">
                            <option value="">None</option>
                            @foreach(['Captain', 'Vice-Captain'] as $role)
                                <option value="{{ $role }}" @selected(old('special_role', $player->special_role) === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="role">Playing position</label>
                        <input type="text" id="role" name="role" value="{{ old('role', $player->role) }}" class="form-control" placeholder="e.g. Fly-half, Prop, Wing">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="weight">Weight</label>
                        <input type="text" id="weight" name="weight" value="{{ old('weight', $player->weight) }}" class="form-control" placeholder="e.g. 92 kg">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="height">Height</label>
                        <input type="text" id="height" name="height" value="{{ old('height', $player->height) }}" class="form-control" placeholder="e.g. 1.82 m">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="date_of_birth">Date of birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', optional($player->date_of_birth)->format('Y-m-d')) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="age">Age</label>
                        <input type="number" id="age" name="age" value="{{ old('age', $player->age) }}" min="10" max="80" class="form-control">
                        <div class="form-text">Calculated automatically from date of birth.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="joined">Joined club</label>
                        <input type="text" id="joined" name="joined" value="{{ old('joined', $player->joined) }}" class="form-control" placeholder="e.g. 2021">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="place_of_birth">Place of birth</label>
                        <input type="text" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth', $player->place_of_birth) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="nationality">Nationality</label>
                        <input type="text" id="nationality" name="nationality" value="{{ old('nationality', $player->nationality) }}" class="form-control" placeholder="e.g. Rwandan">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="honours">Honours</label>
                        <textarea id="honours" name="honours" rows="2" class="form-control">{{ old('honours', $player->honours) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="previous_clubs">Previous clubs</label>
                        <textarea id="previous_clubs" name="previous_clubs" rows="2" class="form-control">{{ old('previous_clubs', $player->previous_clubs) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Career statistics &amp; sponsor</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label" for="games">Appearances</label>
                        <input type="number" id="games" name="games" value="{{ old('games', $player->games ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="points">Points</label>
                        <input type="number" id="points" name="points" value="{{ old('points', $player->points ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="tries">Tries</label>
                        <input type="number" id="tries" name="tries" value="{{ old('tries', $player->tries ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="sponsor">Player sponsor</label>
                        <input type="text" id="sponsor" name="sponsor" value="{{ old('sponsor', $player->sponsor) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="sponsor_desc">Sponsor note</label>
                        <input type="text" id="sponsor_desc" name="sponsor_desc" value="{{ old('sponsor_desc', $player->sponsor_desc) }}" class="form-control">
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
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" @checked(old('is_published', $player->is_published ?? true))>
                    <label class="form-check-label" for="is_published">Show profile on website</label>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Add player' }}</button>
                    <a href="{{ route('admin.players.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Player photo</h5></div>
            <div class="card-panel-body">
                @if($player->image)
                    <img src="{{ media_url($player->image) }}" alt="" class="w-100 rounded mb-2" style="height:200px;object-fit:cover;">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                        <label class="form-check-label small" for="remove_image">Remove current photo</label>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*" data-preview="#playerPreview">
                <img id="playerPreview" class="w-100 rounded mt-2 d-none" alt="Preview" style="height:200px;object-fit:cover;">
                <div class="form-text">Portrait image, ideally 3:4. Max 8 MB.</div>
            </div>
        </div>
    </div>
</div>
