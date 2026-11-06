<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('setting')) {
    /**
     * Read a persisted site setting.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('setting_bool')) {
    function setting_bool(string $key, bool $default = false): bool
    {
        $value = Setting::get($key);

        if ($value === null) {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}

if (! function_exists('media_url')) {
    /**
     * Resolve a stored media path (uploads/foo.jpg or a full URL) to a public URL.
     */
    function media_url(?string $path, ?string $fallback = null): string
    {
        if (blank($path)) {
            return $fallback ? asset($fallback) : asset('images/placeholder.svg');
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}

if (! function_exists('upload_media')) {
    /**
     * Store an uploaded file in public/uploads/{folder} and return its relative path.
     */
    function upload_media(?Illuminate\Http\UploadedFile $file, string $folder = 'general', ?string $oldPath = null, ?array $allowedExtensions = null): ?string
    {
        if (! $file) {
            return $oldPath;
        }

        if (! empty($allowedExtensions)) {
            $ext = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: '');
            if ($ext === '' || ! in_array($ext, $allowedExtensions, true)) {
                abort(422, 'This file type is not allowed.');
            }
        }

        $folder = trim($folder, '/');
        $name = now()->format('YmdHis').'-'.Str::random(8).'.'.strtolower($file->getClientOriginalExtension() ?: 'bin');
        $file->move(public_path('uploads/'.$folder), $name);

        $newPath = 'uploads/'.$folder.'/'.$name;

        if ($oldPath && ! Str::startsWith($oldPath, ['http://', 'https://']) && file_exists(public_path($oldPath))) {
            @unlink(public_path($oldPath));
        }

        return $newPath;
    }
}

if (! function_exists('delete_media')) {
    function delete_media(?string $path): void
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        if (file_exists(public_path($path))) {
            @unlink(public_path($path));
        }
    }
}

if (! function_exists('unique_slug')) {
    function unique_slug(string $value, string $modelClass, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $i = 1;

        while ($modelClass::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $original.'-'.$i++;
        }

        return $slug;
    }
}

if (! function_exists('format_rwf')) {
    function format_rwf(float|int|string|null $amount): string
    {
        return 'RWF '.number_format((float) $amount, 0);
    }
}

if (! function_exists('current_season')) {
    function current_season(): int
    {
        return (int) (App\Models\Season::query()->where('is_active', true)->orderByDesc('year')->value('year') ?? now()->year);
    }
}

if (! function_exists('site_logo')) {
    function site_logo(): string
    {
        return media_url(setting('site_logo'), 'images/1000-hills-logo.png');
    }
}
