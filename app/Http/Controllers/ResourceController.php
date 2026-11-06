<?php

namespace App\Http\Controllers;

use App\Models\Resource;

class ResourceController extends Controller
{
    public function index()
    {
        $category = request('category');
        $year = request('year');

        $resources = Resource::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($year, fn ($q) => $q->where('year', $year))
            ->orderByDesc('year')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Resource::published()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
        $years = Resource::published()->whereNotNull('year')->distinct()->orderByDesc('year')->pluck('year');

        return view('public.resources.index', compact('resources', 'categories', 'years', 'category', 'year'));
    }

    public function download(Resource $resource)
    {
        abort_unless($resource->is_published, 404);

        $resource->increment('downloads');

        if ($resource->external_url) {
            return redirect()->away($resource->external_url);
        }

        abort_unless($resource->file_path && file_exists(public_path($resource->file_path)), 404);

        return response()->download(public_path($resource->file_path), basename($resource->file_path));
    }
}
