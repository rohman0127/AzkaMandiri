<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Portfolio;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $page = Page::active()->where('slug', 'tentang-kami')->first();
        $sampleProjects = Portfolio::active()->latest()->take(4)->get();

        return view('frontend.about', compact('page', 'sampleProjects'));
    }
}

