@php
    $initials = \Illuminate\Support\Str::of($player->name)->explode(' ')->filter()->take(2)->map(fn ($part) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($part, 0, 1)))->implode('');
@endphp

<article class="player-card card-clean h-100">
    <a href="{{ route('players.show', $player) }}" class="d-block text-decoration-none">
        <div class="player-photo">
            @if($player->image)
                <img src="{{ media_url($player->image) }}" alt="{{ $player->name }}" loading="lazy">
            @else
                <span class="player-initials">{{ $initials }}</span>
            @endif
            @if($player->special_role)
                <span class="player-number" style="width:auto; padding:0 .55rem; border-radius:999px; font-family:'Segoe UI',sans-serif; font-size:.64rem;">{{ $player->special_role === 'Vice-Captain' ? 'VC' : 'C' }}</span>
            @endif
            @if($player->role)
                <span class="player-role-tag">{{ $player->role }}</span>
            @endif
        </div>
        <div class="player-body">
            <h3><span class="text-dark">{{ $player->name }}</span></h3>
            <div class="role">{{ $player->position_category ?: ($player->nationality ?: 'Player') }}@if($player->age) · {{ $player->age }} yrs @endif</div>
            <div class="player-stats">
                <div><strong>{{ $player->games }}</strong>Apps</div>
                <div><strong>{{ $player->tries }}</strong>Tries</div>
                <div><strong>{{ $player->points }}</strong>Points</div>
            </div>
        </div>
    </a>
</article>
