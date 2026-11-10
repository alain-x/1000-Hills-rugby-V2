<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleSection;
use App\Support\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query()->withCount('sections');

        if ($search = trim((string) $request->get('q'))) {
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('excerpt', 'like', "%{$search}%"));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->get('status') === 'published');
        }

        $articles = $query->orderedByDate()->paginate(12)->withQueryString();
        $categories = Article::select('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $article = new Article(['category' => 'News', 'author' => auth()->user()->name, 'is_published' => true]);
        $categories = $this->categories();

        return view('admin.articles.create', compact('article', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['slug'] ?: $data['title'], Article::class);

        DB::transaction(function () use ($request, &$data) {
            $data['featured_image'] = upload_media($request->file('featured_image'), 'articles');
            $data['gallery'] = $this->storeGallery($request, []);
            $data['published_at'] = $data['published_at'] ?: ($data['is_published'] ? now() : null);

            $article = Article::create($data);
            $this->syncSections($request, $article);

            Activity::log('created', $article, 'Created article: '.$article->title);
        });

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        $article->load('sections');
        $categories = $this->categories();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validated($request);
        $data['slug'] = unique_slug($data['slug'] ?: $data['title'], Article::class, $article->id);

        DB::transaction(function () use ($request, &$data, $article) {
            if ($request->hasFile('featured_image')) {
                $data['featured_image'] = upload_media($request->file('featured_image'), 'articles', $article->featured_image);
            } else {
                unset($data['featured_image']);
            }

            if ($request->boolean('remove_featured_image')) {
                delete_media($article->featured_image);
                $data['featured_image'] = null;
            }

            $data['gallery'] = $this->storeGallery($request, $article->gallery ?? []);
            $data['published_at'] = $data['published_at'] ?: ($data['is_published'] ? ($article->published_at ?: now()) : null);

            $article->update($data);

            $keptImages = [];
            foreach ($request->input('sections', []) as $section) {
                $existing = array_values(array_filter($section['existing_images'] ?? []));
                $removed = array_values(array_filter($section['remove_images'] ?? []));
                foreach (array_diff($existing, $removed) as $image) {
                    $keptImages[] = $image;
                }
            }

            foreach ($article->sections as $section) {
                foreach ($section->images ?? [] as $image) {
                    if (! in_array($image, $keptImages, true)) {
                        delete_media($image);
                    }
                }
            }

            $article->sections()->delete();

            $this->syncSections($request, $article);

            Activity::log('updated', $article, 'Updated article: '.$article->title);
        });

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        delete_media($article->featured_image);

        foreach ($article->gallery ?? [] as $image) {
            delete_media($image);
        }

        foreach ($article->sections as $section) {
            foreach ($section->images ?? [] as $image) {
                delete_media($image);
            }
        }

        $title = $article->title;
        $article->delete();

        Activity::log('deleted', null, 'Deleted article: '.$title);

        return back()->with('success', 'Article deleted.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'author' => ['nullable', 'string', 'max:120'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
            'gallery.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
            'sections.*.subtitle' => ['nullable', 'string', 'max:200'],
            'sections.*.content' => ['nullable', 'string'],
            'sections.*.images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:8192'],
        ]);

        $validated['slug'] = $validated['slug'] ?? '';
        $validated['is_published'] = $request->boolean('is_published');

        return $validated;
    }

    private function syncSections(Request $request, Article $article): void
    {
        foreach (array_values($request->input('sections', [])) as $index => $section) {
            $subtitle = trim((string) ($section['subtitle'] ?? ''));
            $content = (string) ($section['content'] ?? '');
            $existing = array_values(array_filter($section['existing_images'] ?? []));
            $removed = array_values(array_filter($section['remove_images'] ?? []));
            $images = array_values(array_diff($existing, $removed));

            foreach ($removed as $remove) {
                delete_media($remove);
            }

            $newFiles = $request->file("sections.{$index}.images", []);
            foreach ($newFiles as $file) {
                if ($file) {
                    $images[] = upload_media($file, 'articles');
                }
            }

            if ($subtitle === '' && trim($content) === '' && empty($images)) {
                continue;
            }

            ArticleSection::create([
                'article_id' => $article->id,
                'subtitle' => $subtitle ?: null,
                'content' => $content,
                'images' => $images ?: null,
                'sort_order' => $index,
            ]);
        }
    }

    private function storeGallery(Request $request, array $existing): array
    {
        $gallery = array_values(array_filter($existing));
        $removed = array_values(array_filter($request->input('remove_gallery', [])));

        foreach ($removed as $path) {
            delete_media($path);
            $gallery = array_values(array_diff($gallery, [$path]));
        }

        foreach ($request->file('gallery', []) as $file) {
            if ($file) {
                $gallery[] = upload_media($file, 'articles');
            }
        }

        return $gallery;
    }

    private function categories(): array
    {
        return ['News', 'Match Report', 'Club News', 'Community', 'Academy', 'Foundation', 'Announcement'];
    }
}
