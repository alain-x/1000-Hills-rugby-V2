<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Support\Activity;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = Resource::query();

        if ($search = trim((string) $request->get('q'))) {
            $query->where('title', 'like', "%{$search}%");
        }

        $resources = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.resources.index', compact('resources'));
    }

    public function create()
    {
        $resource = new Resource(['is_published' => true, 'year' => now()->year]);

        return view('admin.resources.create', compact('resource'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['title'], Resource::class);
        $data['file_path'] = upload_media($request->file('file'), 'resources', null, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip']);

        $resource = Resource::create($data);
        Activity::log('created', $resource, 'Uploaded resource: '.$resource->title);

        return redirect()->route('admin.resources.index')->with('success', 'Resource uploaded.');
    }

    public function edit(Resource $resource)
    {
        return view('admin.resources.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        $data = $this->validated($request);

        if ($request->hasFile('file')) {
            $data['file_path'] = upload_media($request->file('file'), 'resources', $resource->file_path);
        } else {
            unset($data['file_path']);
        }

        $resource->update($data);
        Activity::log('updated', $resource, 'Updated resource: '.$resource->title);

        return redirect()->route('admin.resources.index')->with('success', 'Resource updated.');
    }

    public function destroy(Resource $resource)
    {
        delete_media($resource->file_path);
        $title = $resource->title;
        $resource->delete();
        Activity::log('deleted', null, 'Deleted resource: '.$title);

        return back()->with('success', 'Resource deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:80'],
            'year' => ['nullable', 'integer', 'min:1990', 'max:2100'],
            'external_url' => ['nullable', 'url', 'max:500'],
            'file' => ['nullable', 'file', 'max:20480'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['downloads'] = $request->integer('downloads', 0);

        return $data;
    }
}
