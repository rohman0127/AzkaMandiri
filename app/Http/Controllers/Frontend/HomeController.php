<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $services = Service::active()
            ->with('category')
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $portfolios = Portfolio::active()
            ->with('category')
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $recentArticles = Article::published()
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.home', compact('services', 'portfolios', 'testimonials', 'recentArticles'));
    }
}

