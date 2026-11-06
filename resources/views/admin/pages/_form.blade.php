@php($isEdit = $page->exists)
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Page content</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="title">Page title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $page->title) }}" class="form-control @error('title') is-invalid @enderror" required data-slug-source data-slug-target="#slug">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" for="slug">URL slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $page->slug) }}" class="form-control" placeholder="auto-generated from the title">
                        <div class="form-text">Public URL: {{ url('/') }}/<span class="fw-semibold">{{ old('slug', $page->slug) ?: 'your-page' }}</span></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="sort_order">Sort order</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $page->sort_order ?? 0) }}" min="0" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="subtitle">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $page->subtitle) }}" class="form-control" maxlength="255">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="excerpt">Intro / summary</label>
                        <textarea id="excerpt" name="excerpt" rows="2" class="form-control" maxlength="500">{{ old('excerpt', $page->excerpt) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="body">Page body</label>
                        <div data-quill class="bg-white rounded">
                            <div class="quill-editor" style="min-height:320px;">{!! old('body', $page->body) !!}</div>
                            <textarea id="body" name="body" class="d-none">{{ old('body', $page->body) }}</textarea>
                        </div>
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
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" @checked(old('is_published', $page->is_published ?? true))>
                    <label class="form-check-label" for="is_published">Published on website</label>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Create page' }}</button>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>

        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Hero image</h5></div>
            <div class="card-panel-body">
                @if($page->hero_image)
                    <img src="{{ media_url($page->hero_image) }}" alt="" class="w-100 rounded mb-2" style="height:160px;object-fit:cover;">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remove_hero_image" name="remove_hero_image" value="1">
                        <label class="form-check-label small" for="remove_hero_image">Remove current image</label>
                    </div>
                @endif
                <input type="file" name="hero_image" id="hero_image" class="form-control" accept="image/*" data-preview="#heroPreview">
                <img id="heroPreview" class="w-100 rounded mt-2 d-none" alt="Preview" style="height:160px;object-fit:cover;">
                <div class="form-text">JPG, PNG, WebP or AVIF. Max 8 MB.</div>
            </div>
        </div>

        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">SEO</h5></div>
            <div class="card-panel-body">
                <div class="mb-3">
                    <label class="form-label" for="meta_title">Meta title</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="form-control" maxlength="200">
                </div>
                <div>
                    <label class="form-label" for="meta_description">Meta description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="form-control" maxlength="500">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
