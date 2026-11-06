@php($isEdit = $sponsor->exists)
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Partner details</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Partner name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $sponsor->name) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="tier">Partnership tier</label>
                        <input type="text" id="tier" name="tier" value="{{ old('tier', $sponsor->tier) }}" class="form-control" placeholder="e.g. Principal partner, Gold, Community">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="website">Website</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $sponsor->website) }}" class="form-control" placeholder="https://example.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $sponsor->description) }}</textarea>
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
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $sponsor->is_active ?? true))>
                    <label class="form-check-label" for="is_active">Display on website</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $sponsor->sort_order ?? 0) }}" min="0" class="form-control">
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Add sponsor' }}</button>
                    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Partner logo</h5></div>
            <div class="card-panel-body">
                @if($sponsor->logo_path)
                    <div class="border rounded bg-white d-grid p-2 mb-2" style="height:130px;place-items:center;">
                        <img src="{{ media_url($sponsor->logo_path) }}" alt="" style="max-height:110px;max-width:100%;object-fit:contain;">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1">
                        <label class="form-check-label small" for="remove_logo">Remove current logo</label>
                    </div>
                @endif
                <input type="file" name="logo" class="form-control" accept="image/*" data-preview="#sponsorPreview">
                <img id="sponsorPreview" class="w-100 rounded mt-2 d-none bg-light p-2" alt="Preview" style="height:130px;object-fit:contain;">
                <div class="form-text">PNG or SVG with transparent background works best.</div>
            </div>
        </div>
    </div>
</div>
