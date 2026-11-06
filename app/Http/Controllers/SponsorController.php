<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::where('is_active', true)->orderBy('sort_order')->get();

        return view('public.sponsors.index', compact('sponsors'));
    }
}
