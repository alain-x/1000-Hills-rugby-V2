<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $fillable = [
        'home_team', 'away_team', 'home_logo', 'away_logo', 'match_date', 'match_time',
        'competition', 'gender', 'season', 'stadium', 'status', 'home_score', 'away_score',
        'notes', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', 'SCHEDULED')->orderBy('match_date');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'COMPLETED')->orderByDesc('match_date');
    }

    public function getIsHomeAttribute(): bool
    {
        return str_contains(strtolower($this->home_team), '1000 hills');
    }

    public function getResultAttribute(): string
    {
        if ($this->status !== 'COMPLETED') {
            return '—';
        }

        if ($this->home_score === $this->away_score) {
            return 'Draw';
        }

        return $this->home_score > $this->away_score ? 'Home win' : 'Away win';
    }
}
