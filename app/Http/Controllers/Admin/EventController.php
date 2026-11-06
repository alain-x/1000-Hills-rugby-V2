<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Support\Activity;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($search = trim((string) $request->get('q'))) {
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('location', 'like', "%{$search}%"));
        }

        if ($request->get('when') === 'upcoming') {
            $query->whereDate('event_date', '>=', today());
        } elseif ($request->get('when') === 'past') {
            $query->whereDate('event_date', '<', today());
        }

        $events = $query->orderByDesc('event_date')->paginate(12)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $event = new Event(['event_date' => today(), 'frequency' => 'One-time', 'is_published' => true]);

        return view('admin.events.create', compact('event'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['slug'] ?: $data['title'], Event::class);
        $data['image'] = upload_media($request->file('image'), 'events');

        $event = Event::create($data);
        Activity::log('created', $event, 'Created event: '.$event->title);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['slug'] ?: $data['title'], Event::class, $event->id);

        if ($request->hasFile('image')) {
            $data['image'] = upload_media($request->file('image'), 'events', $event->image);
        } else {
            unset($data['image']);
        }

        if ($request->boolean('remove_image')) {
            delete_media($event->image);
            $data['image'] = null;
        }

        $event->update($data);
        Activity::log('updated', $event, 'Updated event: '.$event->title);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        delete_media($event->image);
        $title = $event->title;
        $event->delete();
        Activity::log('deleted', null, 'Deleted event: '.$title);

        return back()->with('success', 'Event deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'event_date' => ['required', 'date'],
            'event_time' => ['nullable', 'string', 'max:60'],
            'location' => ['nullable', 'string', 'max:200'],
            'participants' => ['nullable', 'string', 'max:200'],
            'frequency' => ['required', 'string', 'max:40'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
        ]);

        $data['slug'] = $data['slug'] ?? '';
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
