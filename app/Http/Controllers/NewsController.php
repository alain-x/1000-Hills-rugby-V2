<?php

namespace App\Http\Controllers;

use App\Models\Article;

class NewsController extends Controller
{
    public function index()
    {
        $category = request('category');
        $search = trim((string) request('q'));

        $articles = Article::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($search !== '', fn ($q) => $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            }))
            ->orderedByDate()
            ->paginate(9)
            ->withQueryString();

        $categories = Article::published()->select('category')->distinct()->orderBy('category')->pluck('category');

        return view('public.news.index', compact('articles', 'categories', 'category', 'search'));
    }

    public function show(Article $article)
    {
        abort_unless($article->is_published, 404);

        $article->increment('views');
        $article->load('sections');

        // Other stories, newest first.
        $related = Article::published()
            ->whereKeyNot($article->id)
            ->orderedByDate()
            ->take(3)
            ->get();

        return view('public.news.show', compact('article', 'related'));
    }
}
