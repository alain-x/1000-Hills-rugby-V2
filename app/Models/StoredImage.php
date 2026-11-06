<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoredImage extends Model
{
    protected $fillable = ['path', 'mime', 'data'];

    /** @var array<string, int>|null */
    protected static ?array $pathMap = null;

    public static function idForPath(string $path): ?int
    {
        $path = static::normalizePath($path);

        if ($path === '') {
            return null;
        }

        if (static::$pathMap === null) {
            try {
                static::$pathMap = static::query()->pluck('id', 'path')->all();
            } catch (\Throwable) {
                static::$pathMap = [];
            }
        }

        return static::$pathMap[$path] ?? null;
    }

    public static function storeBytes(string $path, string $mime, string $binary): self
    {
        $path = static::normalizePath($path);

        $row = static::query()->updateOrCreate(
            ['path' => $path],
            ['mime' => $mime, 'data' => base64_encode($binary)]
        );

        if (static::$pathMap === null) {
            static::$pathMap = [];
        }

        static::$pathMap[$path] = $row->id;

        return $row;
    }

    public static function deletePath(?string $path): void
    {
        $path = static::normalizePath((string) $path);

        if ($path === '' || str_starts_with($path, 'data:') || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        try {
            static::query()->where('path', $path)->delete();
        } catch (\Throwable) {
            return;
        }

        if (static::$pathMap !== null) {
            unset(static::$pathMap[$path]);
        }
    }

    public static function normalizePath(string $path): string
    {
        $path = str_replace('\\', '/', trim($path));

        return ltrim($path, '/');
    }
};
