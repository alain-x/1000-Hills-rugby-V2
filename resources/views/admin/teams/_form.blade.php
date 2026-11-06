@php($isEdit = $team->exists)
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
            <div class="card-panel-header"><h5 class="mb-0">Team details</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label" for="name">Team name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $team->name) }}" class="form-control @error('name') is-invalid @enderror" required data-slug-source data-slug-target="#slug">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label" for="slug">URL slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $team->slug) }}" class="form-control" placeholder="auto-generated">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="category">Squad category <span class="text-danger">*</span></label>
                        <select id="category" name="category" class="form-select" required>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $team->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Players are grouped by this category on the public site.</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="">Not specified</option>
                            @foreach(['Men', 'Women', 'Boys', 'Girls', 'Mixed'] as $gender)
                                <option value="{{ $gender }}" @selected(old('gender', $team->gender) === $gender)>{{ $gender }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="age_group">Age group</label>
                        <input type="text" id="age_group" name="age_group" value="{{ old('age_group', $team->age_group) }}" class="form-control" placeholder="e.g. U18, Senior">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="coach">Head coach</label>
                        <input type="text" id="coach" name="coach" value="{{ old('coach', $team->coach) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="home_ground">Home ground</label>
                        <input type="text" id="home_ground" name="home_ground" value="{{ old('home_ground', $team->home_ground) }}" class="form-control" placeholder="e.g. Don Bosco Gatenga">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="5" class="form-control">{{ old('description', $team->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Status &amp; order</h5></div>
            <div class="card-panel-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $team->is_active ?? true))>
                    <label class="form-check-label" for="is_active">Visible on website</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $team->sort_order ?? 0) }}" min="0" class="form-control">
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Create team' }}</button>
                    <a href="{{ route('admin.teams.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Team logo</h5></div>
            <div class="card-panel-body">
                @if($team->logo)
                    <img src="{{ media_url($team->logo) }}" alt="" class="w-100 rounded mb-2 bg-light p-2" style="height:120px;object-fit:contain;">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1">
                        <label class="form-check-label small" for="remove_logo">Remove current logo</label>
                    </div>
                @endif
                <input type="file" name="logo" class="form-control" accept="image/*" data-preview="#logoPreview">
                <img id="logoPreview" class="w-100 rounded mt-2 d-none bg-light p-2" alt="Preview" style="height:120px;object-fit:contain;">
            </div>
        </div>
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Cover image</h5></div>
            <div class="card-panel-body">
                @if($team->cover_image)
                    <img src="{{ media_url($team->cover_image) }}" alt="" class="w-100 rounded mb-2" style="height:140px;object-fit:cover;">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remove_cover_image" name="remove_cover_image" value="1">
                        <label class="form-check-label small" for="remove_cover_image">Remove current cover</label>
                    </div>
                @endif
                <input type="file" name="cover_image" class="form-control" accept="image/*" data-preview="#coverPreview">
                <img id="coverPreview" class="w-100 rounded mt-2 d-none" alt="Preview" style="height:140px;object-fit:cover;">
            </div>
        </div>
    </div>
</div>
