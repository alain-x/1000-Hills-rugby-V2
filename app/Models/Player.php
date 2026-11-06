<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    protected $fillable = [
        'team_id', 'team', 'name', 'slug', 'image', 'date_of_birth', 'age', 'role',
        'position_category', 'special_role', 'weight', 'height', 'games', 'points', 'tries',
        'place_of_birth', 'nationality', 'honours', 'joined', 'previous_clubs',
        'sponsor', 'sponsor_desc', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function teamRelation(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeForTeam(Builder $query, string $team): Builder
    {
        return $query->where('team', $team);
    }
}
