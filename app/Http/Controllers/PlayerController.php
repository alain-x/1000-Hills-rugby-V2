<?php

namespace App\Http\Controllers;

use App\Models\Player;

class PlayerController extends Controller
{
    public function show(Player $player)
    {
        abort_unless($player->is_published, 404);

        $team = $player->teamRelation;
        $teamMates = Player::published()
            ->where('team', $player->team)
            ->whereKeyNot($player->id)
            ->take(6)
            ->get();

        return view('public.players.show', compact('player', 'team', 'teamMates'));
    }
}
