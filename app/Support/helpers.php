<?php

use App\Models\Setting;
use App\Models\StoredImage;
use App\Support\ImageStringStore;
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
            return $fallback ? media_url($fallback) : media_placeholder();
        }

        if (Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return $path;
        }

        $storedId = StoredImage::idForPath($path);

        if ($storedId) {
            return route('media.show', $storedId);
        }

        $publicPath = public_path(StoredImage::normalizePath($path));

        if (is_file($publicPath)) {
            return asset(StoredImage::normalizePath($path));
        }

        return $fallback ? media_url($fallback) : media_placeholder();
    }
}

if (! function_exists('media_placeholder')) {
    function media_placeholder(): string
    {
        $storedId = StoredImage::idForPath('images/placeholder.svg');

        if ($storedId) {
            return route('media.show', $storedId);
        }

        return asset('images/placeholder.svg');
    }
}

if (! function_exists('upload_media')) {
    /**
     * Store an uploaded image as a base64 string in the database.
     * Other files are still saved under public/uploads/{folder}.
     */
    function upload_media(?Illuminate\Http\UploadedFile $file, string $folder = 'general', ?string $oldPath = null, ?array $allowedExtensions = null): ?string
    {
        if (! $file) {
            return $oldPath;
        }

        $ext = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: '');

        if (! empty($allowedExtensions)) {
            if ($ext === '' || ! in_array($ext, $allowedExtensions, true)) {
                abort(422, 'This file type is not allowed.');
            }
        }

        $folder = trim($folder, '/');
        $name = now()->format('YmdHis').'-'.Str::random(8).'.'.($ext !== '' ? $ext : 'bin');
        $store = app(ImageStringStore::class);
        $mime = $store->mimeForExtension($ext, $file->getMimeType());

        if ($mime && empty($allowedExtensions)) {
            $binary = file_get_contents($file->getRealPath());

            if ($binary === false) {
                abort(422, 'The image could not be read.');
            }

            $newPath = 'uploads/'.$folder.'/'.$name;
            StoredImage::storeBytes($newPath, $mime, $binary);
            delete_media($oldPath);

            return $newPath;
        }

        $destination = public_path('uploads/'.$folder);

        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $name);

        $newPath = 'uploads/'.$folder.'/'.$name;
        delete_media($oldPath);

        return $newPath;
    }
}

if (! function_exists('delete_media')) {
    function delete_media(?string $path): void
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return;
        }

        StoredImage::deletePath($path);

        $publicPath = public_path(StoredImage::normalizePath($path));

        if (is_file($publicPath)) {
            @unlink($publicPath);
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
