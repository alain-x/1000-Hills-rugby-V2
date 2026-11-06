<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklySchedule;
use App\Support\Activity;
use Illuminate\Http\Request;

class WeeklyScheduleController extends Controller
{
    public function index()
    {
        $schedules = WeeklySchedule::orderBy('sort_order')->orderBy('day')->get();

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        return redirect()->route('admin.schedules.index');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $schedule = WeeklySchedule::create($data);
        Activity::log('created', $schedule, 'Added weekly schedule entry');

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule entry added.');
    }

    public function edit(WeeklySchedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, WeeklySchedule $schedule)
    {
        $schedule->update($this->validated($request));
        Activity::log('updated', $schedule, 'Updated weekly schedule entry');

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule entry updated.');
    }

    public function destroy(WeeklySchedule $schedule)
    {
        $schedule->delete();
        Activity::log('deleted', null, 'Removed weekly schedule entry');

        return back()->with('success', 'Schedule entry removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'day' => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'time_range' => ['required', 'string', 'max:80'],
            'location' => ['required', 'string', 'max:200'],
            'activity' => ['required', 'string', 'max:200'],
        ]);

        $data['sort_order'] = (int) $request->input('sort_order', 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
