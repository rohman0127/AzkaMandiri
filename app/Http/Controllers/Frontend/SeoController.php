<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $services = Service::active()->select('slug', 'updated_at')->get();
        $portfolios = Portfolio::active()->select('slug', 'updated_at')->get();
        $articles = Article::published()->select('slug', 'updated_at')->get();
        $pages = Page::active()->select('slug', 'updated_at')->get();

        $content = view('frontend.seo.sitemap', compact('services', 'portfolios', 'articles', 'pages'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function robots(): Response
    {
        $customRobots = Setting::get('custom_robots_txt');

        if (!empty($customRobots)) {
            $content = $customRobots;
        } else {
            $sitemapUrl = url('/sitemap.xml');
            $content = "User-agent: *\nDisallow: /admin/\nDisallow: /admin\nAllow: /\n\nSitemap: {$sitemapUrl}\n";
        }

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}

