<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerReport extends Model
{
    public const SCORES = [
        'effort' => 'Effort',
        'skill' => 'Skill',
        'discipline' => 'Discipline',
        'teamwork' => 'Teamwork',
        'fitness' => 'Fitness',
    ];

    protected $fillable = [
        'team_id', 'player_id', 'coach_id', 'report_date',
        'effort', 'skill', 'discipline', 'teamwork', 'fitness', 'rating', 'report',
    ];

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
            'rating' => 'float',
        ];
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public static function ratingFrom(array $scores): float
    {
        $values = array_map('intval', array_intersect_key($scores, self::SCORES));

        return round(array_sum($values) / max(1, count(self::SCORES)), 1);
    }
}
