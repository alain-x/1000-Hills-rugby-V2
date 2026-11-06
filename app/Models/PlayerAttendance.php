<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerAttendance extends Model
{
    public const STATUSES = [
        'present' => 'Present',
        'late' => 'Late',
        'absent' => 'Absent',
        'excused' => 'Excused',
        'injured' => 'Injured',
        'sick' => 'Sick',
    ];

    public const ATTENDED = ['present', 'late'];

    protected $fillable = [
        'session_id', 'team_id', 'player_id', 'coach_id', 'session_date', 'session_type',
        'status', 'minutes', 'rpe', 'note',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(SquadSession::class, 'session_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function loadScore(): ?int
    {
        if (! $this->minutes || ! $this->rpe || ! in_array($this->status, self::ATTENDED, true)) {
            return null;
        }

        return $this->minutes * $this->rpe;
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
}
