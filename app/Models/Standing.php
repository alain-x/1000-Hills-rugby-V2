<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends Model
{
    protected $table = 'league_standings';

    protected $fillable = [
        'club_id', 'competition_id', 'season_id', 'gender_id',
        'matches_played', 'matches_won', 'matches_drawn', 'matches_lost',
        'tries_for', 'tries_against', 'points_for', 'points_against',
        'points_difference', 'league_points', 'form_score',
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }
}
