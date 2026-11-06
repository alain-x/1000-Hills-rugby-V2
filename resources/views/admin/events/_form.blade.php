@php($isEdit = $event->exists)
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Event details</h5></div>
            <div class="card-panel-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="title">Event title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" class="form-control" required data-slug-source data-slug-target="#slug">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label" for="slug">URL slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $event->slug) }}" class="form-control" placeholder="auto-generated">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="frequency">Frequency <span class="text-danger">*</span></label>
                        <select id="frequency" name="frequency" class="form-select" required>
                            @foreach(['One-time', 'Weekly', 'Monthly', 'Annual', 'Seasonal'] as $frequency)
                                <option value="{{ $frequency }}" @selected(old('frequency', $event->frequency) === $frequency)>{{ $frequency }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="event_date">Date <span class="text-danger">*</span></label>
                        <input type="date" id="event_date" name="event_date" value="{{ old('event_date', optional($event->event_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="event_time">Time</label>
                        <input type="text" id="event_time" name="event_time" value="{{ old('event_time', $event->event_time) }}" class="form-control" placeholder="e.g. 09:00 - 14:00">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="participants">Participants</label>
                        <input type="text" id="participants" name="participants" value="{{ old('participants', $event->participants) }}" class="form-control" placeholder="e.g. U16 & U18 squads">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="location">Location</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" class="form-control" placeholder="Venue or ground">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="8" class="form-control">{{ old('description', $event->description) }}</textarea>
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
                    <input class="form-check-input" type="checkbox" role="switch" id="is_published" name="is_published" value="1" @checked(old('is_published', $event->is_published ?? true))>
                    <label class="form-check-label" for="is_published">Published on website</label>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>{{ $isEdit ? 'Save changes' : 'Create event' }}</button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-admin-outline">Cancel</a>
                </div>
            </div>
        </div>
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Event image</h5></div>
            <div class="card-panel-body">
                @if($event->image)
                    <img src="{{ media_url($event->image) }}" alt="" class="w-100 rounded mb-2" style="height:150px;object-fit:cover;">
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                        <label class="form-check-label small" for="remove_image">Remove current image</label>
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*" data-preview="#eventPreview">
                <img id="eventPreview" class="w-100 rounded mt-2 d-none" alt="Preview" style="height:150px;object-fit:cover;">
            </div>
        </div>
    </div>
</div>
