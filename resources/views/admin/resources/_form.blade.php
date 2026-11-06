@php($isEdit = $resource->exists)
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Resource details</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $resource->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="category">Category</label>
                        <input type="text" id="category" name="category" value="{{ old('category', $resource->category) }}" class="form-control" placeholder="e.g. Policies, Forms, Annual reports" list="resource-categories">
                        <datalist id="resource-categories">
                            <option value="Policies"><option value="Forms"><option value="Annual reports"><option value="Safeguarding"><option value="Club documents">
                        </datalist>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="year">Year</label>
                        <input type="number" id="year" name="year" value="{{ old('year', $resource->year ?? now()->year) }}" min="1990" max="2100" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $resource->description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="external_url">External URL (optional)</label>
                        <input type="url" id="external_url" name="external_url" value="{{ old('external_url', $resource->external_url) }}" class="form-control" placeholder="https://example.com/document.pdf">
                        <div class="form-text">If provided, visitors are sent to this link instead of a downloaded file.</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="file">File {{ $isEdit ? '(leave blank to keep current file)' : '' }}</label>
                        <input type="file" id="file" name="file" class="form-control">
                        <div class="form-text">PDF, Word, Excel, PowerPoint or ZIP. Max 20 MB.</div>
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
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" @checked(old('is_published', $resource->is_published ?? true))>
                    <label class="form-check-label" for="is_published">Published on website</label>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="downloads">Download count</label>
                    <input type="number" id="downloads" name="downloads" value="{{ old('downloads', $resource->downloads ?? 0) }}" min="0" class="form-control">
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Upload resource' }}</button>
                    <a href="{{ route('admin.resources.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>
        @if($resource->file_path)
            <div class="card-panel">
                <div class="card-panel-header"><h5 class="mb-0">Current file</h5></div>
                <div class="card-panel-body">
                    <a href="{{ media_url($resource->file_path) }}" target="_blank" rel="noopener" class="btn btn-admin-outline w-100"><i class="bi bi-file-earmark-arrow-down me-1"></i>Open file</a>
                </div>
            </div>
        @endif
    </div>
</div>
