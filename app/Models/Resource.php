<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'category', 'year', 'file_path', 'external_url', 'is_published', 'downloads'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'year' => 'integer',
            'downloads' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function getDownloadUrlAttribute(): string
    {
        if ($this->external_url) {
            return $this->external_url;
        }

        if ($this->file_path) {
            return asset($this->file_path);
        }

        return '#';
    }

    public function getIsExternalAttribute(): bool
    {
        return ! empty($this->external_url);
    }
}
