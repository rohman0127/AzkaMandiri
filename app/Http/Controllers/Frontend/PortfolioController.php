<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        $query = Portfolio::active()->with('category')->orderBy('sort_order');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($catSlug = $request->input('kategori')) {
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        $portfolios = $query->paginate(9)->withQueryString();
        $categories = PortfolioCategory::active()->withCount(['portfolios' => function ($q) {
            $q->active();
        }])->orderBy('sort_order')->get();

        return view('frontend.portfolios.index', compact('portfolios', 'categories'));
    }

    public function show(string $slug): View
    {
        $portfolio = Portfolio::active()
            ->with(['category', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedPortfolios = Portfolio::active()
            ->where('id', '!=', $portfolio->id)
            ->take(3)
            ->get();

        return view('frontend.portfolios.show', compact('portfolio', 'relatedPortfolios'));
    }
}

