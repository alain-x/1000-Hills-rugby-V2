<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function show(string $page)
    {
        $content = Page::published()->where('slug', $page)->firstOrFail();

        return view('public.page', ['page' => $content]);
    }
}
