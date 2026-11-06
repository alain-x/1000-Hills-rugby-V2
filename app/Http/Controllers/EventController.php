<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\WeeklySchedule;

class EventController extends Controller
{
    public function index()
    {
        $upcoming = Event::published()->upcoming()->paginate(6, ['*'], 'upcoming_page');
        $past = Event::published()
            ->whereDate('event_date', '<', today())
            ->orderByDesc('event_date')
            ->paginate(6, ['*'], 'past_page');
        $schedule = WeeklySchedule::where('is_active', true)->orderBy('sort_order')->get();

        return view('public.events.index', compact('upcoming', 'past', 'schedule'));
    }

    public function show(Event $event)
    {
        abort_unless($event->is_published, 404);

        $others = Event::published()
            ->whereKeyNot($event->id)
            ->upcoming()
            ->take(3)
            ->get();

        return view('public.events.show', compact('event', 'others'));
    }
}
