<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Service::active()->with('category')->orderBy('sort_order');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($catSlug = $request->input('kategori')) {
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        $services = $query->paginate(9)->withQueryString();
        $categories = ServiceCategory::active()->withCount(['services' => function ($q) {
            $q->active();
        }])->orderBy('sort_order')->get();

        return view('frontend.services.index', compact('services', 'categories'));
    }

    public function show(string $slug): View
    {
        $service = Service::active()
            ->with(['category', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedServices = Service::active()
            ->where('id', '!=', $service->id)
            ->where('service_category_id', $service->service_category_id)
            ->take(3)
            ->get();

        if ($relatedServices->isEmpty()) {
            $relatedServices = Service::active()
                ->where('id', '!=', $service->id)
                ->take(3)
                ->get();
        }

        return view('frontend.services.show', compact('service', 'relatedServices'));
    }
}

