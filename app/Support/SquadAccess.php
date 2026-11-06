<?php

namespace App\Support;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;

class SquadAccess
{
    public static function teamsFor(User $user): Collection
    {
        if ($user->isCoach()) {
            return Team::query()->whereKey($user->team_id)->orderBy('sort_order')->get();
        }

        return Team::active()->get();
    }

    public static function team(User $user, mixed $requestedId): ?Team
    {
        $teams = self::teamsFor($user);

        if ($user->isCoach()) {
            return $teams->first();
        }

        return $teams->firstWhere('id', (int) $requestedId) ?? $teams->first();
    }

    public static function players(?Team $team): Collection
    {
        if (! $team) {
            return collect();
        }

        return Player::query()
            ->where(fn ($query) => $query->where('team_id', $team->id)->orWhere('team', $team->category))
            ->orderBy('name')
            ->get();
    }
}
