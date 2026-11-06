@php($isEdit = $member->exists)
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Member details</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Full name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $member->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="role">Role / title</label>
                        <input type="text" id="role" name="role" value="{{ old('role', $member->role) }}" class="form-control" placeholder="e.g. Head Coach, Club President">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $member->email) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $member->phone) }}" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="bio">Biography</label>
                        <textarea id="bio" name="bio" rows="6" class="form-control">{{ old('bio', $member->bio) }}</textarea>
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
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $member->is_active ?? true))>
                    <label class="form-check-label" for="is_active">Visible on website</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Sort order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $member->sort_order ?? 0) }}" min="0" class="form-control">
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Add staff member' }}</button>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Photo</h5></div>
            <div class="card-panel-body">
                @if($member->image)
                    <img src="{{ media_url($member->image) }}" alt="" class="w-100 rounded mb-2" style="height:200px;object-fit:cover;">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                        <label class="form-check-label small" for="remove_image">Remove current photo</label>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*" data-preview="#staffPreview">
                <img id="staffPreview" class="w-100 rounded mt-2 d-none" alt="Preview" style="height:200px;object-fit:cover;">
            </div>
        </div>
    </div>
</div>
