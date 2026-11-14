<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_services' => Service::count(),
            'total_portfolios' => Portfolio::count(),
            'total_articles' => Article::count(),
            'total_testimonials' => Testimonial::count(),
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::unread()->count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentPortfolios = Portfolio::latest()->take(4)->get();
        $recentArticles = Article::latest()->take(4)->get();

        return view('admin.dashboard.index', compact('stats', 'recentMessages', 'recentPortfolios', 'recentArticles'));
    }
}

