<?php

namespace App\Http\Controllers;

use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('public.staff.index', compact('staff'));
    }
}
