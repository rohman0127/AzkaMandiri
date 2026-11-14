<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::published()->with('category')->latest('published_at');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($catSlug = $request->input('kategori')) {
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        $articles = $query->paginate(6)->withQueryString();
        $categories = ArticleCategory::active()->withCount(['articles' => function ($q) {
            $q->published();
        }])->orderBy('sort_order')->get();

        return view('frontend.articles.index', compact('articles', 'categories'));
    }

    public function show(string $slug): View
    {
        $article = Article::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views count safely
        $article->increment('views_count');

        $recentArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.articles.show', compact('article', 'recentArticles'));
    }
}

