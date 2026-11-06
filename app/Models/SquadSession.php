<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SquadSession extends Model
{
    public const TYPES = [
        'training' => 'Training',
        'match' => 'Match',
        'gym' => 'Gym',
        'recovery' => 'Recovery',
        'video' => 'Video review',
        'meeting' => 'Team meeting',
        'other' => 'Other',
    ];

    public const FOCUSES = [
        'general' => 'General',
        'attack' => 'Attack',
        'defence' => 'Defence',
        'scrum' => 'Scrum',
        'lineout' => 'Lineout',
        'kicking' => 'Kicking',
        'contact' => 'Contact',
        'skills' => 'Skills',
        'fitness' => 'Fitness',
        'review' => 'Review',
    ];

    public const INTENSITIES = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
    ];

    public const STATUSES = [
        'scheduled' => 'Scheduled',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    protected $fillable = [
        'team_id', 'created_by', 'title', 'session_type', 'focus', 'starts_at',
        'duration_minutes', 'location', 'intensity', 'opponent', 'status', 'plan',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(PlayerAttendance::class, 'session_id');
    }
}
