<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Support\Activity;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::orderBy('sort_order')->orderBy('name')->paginate(15);

        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        $member = new Staff(['is_active' => true]);

        return view('admin.staff.create', compact('member'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = upload_media($request->file('image'), 'staff');

        $member = Staff::create($data);
        Activity::log('created', $member, 'Added staff member: '.$member->name);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member added.');
    }

    public function show(Staff $staff)
    {
        return redirect()->route('admin.staff.edit', $staff);
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', ['member' => $staff]);
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = upload_media($request->file('image'), 'staff', $staff->image);
        } else {
            unset($data['image']);
        }

        if ($request->boolean('remove_image')) {
            delete_media($staff->image);
            $data['image'] = null;
        }

        $staff->update($data);
        Activity::log('updated', $staff, 'Updated staff member: '.$staff->name);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated.');
    }

    public function destroy(Staff $staff)
    {
        delete_media($staff->image);
        $name = $staff->name;
        $staff->delete();
        Activity::log('deleted', null, 'Removed staff member: '.$name);

        return back()->with('success', 'Staff member removed.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'role' => ['nullable', 'string', 'max:120'],
            'bio' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:40'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
