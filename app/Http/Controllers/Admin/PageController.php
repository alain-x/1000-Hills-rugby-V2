<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\Activity;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('sort_order')->orderBy('title')->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $page = new Page(['is_published' => true]);

        return view('admin.pages.create', compact('page'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['slug'] ?: $data['title'], Page::class);
        $data['hero_image'] = upload_media($request->file('hero_image'), 'pages');

        $page = Page::create($data);
        Activity::log('created', $page, 'Created page: '.$page->title);

        return redirect()->route('admin.pages.index')->with('success', 'Page created.');
    }

    public function show(Page $page)
    {
        return redirect()->route('admin.pages.edit', $page);
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['slug'] ?: $data['title'], Page::class, $page->id);

        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = upload_media($request->file('hero_image'), 'pages', $page->hero_image);
        } else {
            unset($data['hero_image']);
        }

        if ($request->boolean('remove_hero_image')) {
            delete_media($page->hero_image);
            $data['hero_image'] = null;
        }

        $page->update($data);
        Activity::log('updated', $page, 'Updated page: '.$page->title);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated.');
    }

    public function destroy(Page $page)
    {
        delete_media($page->hero_image);
        $title = $page->title;
        $page->delete();
        Activity::log('deleted', null, 'Deleted page: '.$title);

        return back()->with('success', 'Page deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:160'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
        ]);

        $data['slug'] = $data['slug'] ?? '';
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
