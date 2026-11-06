@php($isEdit = $article->exists)
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Article content</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" class="form-control @error('title') is-invalid @enderror" required data-slug-source data-slug-target="#slug">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" for="slug">URL slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $article->slug) }}" class="form-control" placeholder="auto-generated from the title">
                        <div class="form-text">Public URL: {{ url('/news') }}/<span class="fw-semibold">{{ old('slug', $article->slug) ?: 'your-slug' }}</span></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="category">Category <span class="text-danger">*</span></label>
                        <select id="category" name="category" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" @selected(old('category', $article->category) === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="excerpt">Short summary</label>
                        <textarea id="excerpt" name="excerpt" rows="2" class="form-control" maxlength="500">{{ old('excerpt', $article->excerpt) }}</textarea>
                        <div class="form-text">Used on news cards and search results (max 500 characters).</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="body">Article body</label>
                        <div data-quill class="bg-white rounded">
                            <div class="quill-editor" style="min-height:260px;">{!! old('body', $article->body) !!}</div>
                            <textarea id="body" name="body" class="d-none">{{ old('body', $article->body) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="author">Author</label>
                        <input type="text" id="author" name="author" value="{{ old('author', $article->author) }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="published_at">Publish date &amp; time</label>
                        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}" class="form-control">
                        <div class="form-text">Leave blank to publish immediately when status is published.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-panel mb-4">
            <div class="card-panel-header">
                <div><h5 class="mb-0">Article sections</h5><span class="text-muted small">Optional blocks with a subtitle, text and images.</span></div>
            </div>
            <div class="card-panel-body">
                @php($existingSections = $article->relationLoaded('sections') ? $article->sections : collect())
                @foreach($existingSections as $index => $section)
                    <div class="border rounded-3 p-3 mb-3 bg-light-subtle">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge-soft">Section {{ $loop->iteration }}</span>
                        </div>
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label">Subtitle</label>
                                <input type="text" name="sections[{{ $index }}][subtitle]" value="{{ old('sections.'.$index.'.subtitle', $section->subtitle) }}" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Content</label>
                                <textarea name="sections[{{ $index }}][content]" rows="4" class="form-control">{{ old('sections.'.$index.'.content', $section->content) }}</textarea>
                            </div>
                            @if($section->images)
                                <div class="col-12">
                                    <label class="form-label">Current images</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($section->images as $image)
                                            <label class="position-relative border rounded p-1 bg-white" style="width:96px; cursor:pointer;">
                                                <img src="{{ media_url($image) }}" alt="" class="w-100 rounded" style="height:70px; object-fit:cover;">
                                                <input type="hidden" name="sections[{{ $index }}][existing_images][]" value="{{ $image }}">
                                                <span class="d-block text-center small mt-1"><input type="checkbox" name="sections[{{ $index }}][remove_images][]" value="{{ $image }}"> Remove</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <label class="form-label">Add images</label>
                                <input type="file" name="sections[{{ $index }}][images][]" class="form-control" accept="image/*" multiple>
                            </div>
                        </div>
                    </div>
                @endforeach

                @for($i = $existingSections->count(); $i < $existingSections->count() + 2; $i++)
                    <div class="border rounded-3 p-3 mb-3">
                        <span class="badge-muted d-inline-block mb-2">New section</span>
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label">Subtitle</label>
                                <input type="text" name="sections[{{ $i }}][subtitle]" value="{{ old('sections.'.$i.'.subtitle') }}" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Content</label>
                                <textarea name="sections[{{ $i }}][content]" rows="4" class="form-control">{{ old('sections.'.$i.'.content') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Images</label>
                                <input type="file" name="sections[{{ $i }}][images][]" class="form-control" accept="image/*" multiple>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Publishing</h5></div>
            <div class="card-panel-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" @checked(old('is_published', $article->is_published ?? true))>
                    <label class="form-check-label" for="is_published">Published</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $article->is_featured))>
                    <label class="form-check-label" for="is_featured">Feature on homepage</label>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-admin-forest"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Create article' }}</button>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>

        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Featured image</h5></div>
            <div class="card-panel-body">
                @if($article->featured_image)
                    <img src="{{ media_url($article->featured_image) }}" alt="" class="w-100 rounded mb-2" style="height:160px; object-fit:cover;">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remove_featured_image" name="remove_featured_image" value="1">
                        <label class="form-check-label small" for="remove_featured_image">Remove current image</label>
                    </div>
                @endif
                <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*" data-preview="#featuredPreview">
                <img id="featuredPreview" class="w-100 rounded mt-2 d-none" alt="Preview" style="height:160px; object-fit:cover;">
                <div class="form-text">JPG, PNG, WebP or AVIF. Max 8 MB.</div>
            </div>
        </div>

        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Photo gallery</h5></div>
            <div class="card-panel-body">
                @if($article->gallery)
                    <div class="row g-2 mb-3">
                        @foreach($article->gallery as $image)
                            <div class="col-6">
                                <label class="d-block border rounded p-1 bg-white" style="cursor:pointer;">
                                    <img src="{{ media_url($image) }}" alt="" class="w-100 rounded" style="height:70px; object-fit:cover;">
                                    <span class="d-block text-center small mt-1"><input type="checkbox" name="remove_gallery[]" value="{{ $image }}"> Remove</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                <div class="form-text">Add multiple gallery images at once.</div>
            </div>
        </div>

        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">SEO</h5></div>
            <div class="card-panel-body">
                <div class="mb-3">
                    <label class="form-label" for="meta_title">Meta title</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $article->meta_title) }}" class="form-control" maxlength="200">
                </div>
                <div>
                    <label class="form-label" for="meta_description">Meta description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="form-control" maxlength="500">{{ old('meta_description', $article->meta_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
