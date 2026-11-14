<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PortfolioImage;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $query = Portfolio::with('category')->orderBy('sort_order');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('portfolio_category_id', $categoryId);
        }

        $portfolios = $query->paginate(10)->withQueryString();
        $categories = PortfolioCategory::orderBy('name')->get();

        return view('admin.portfolios.index', compact('portfolios', 'categories'));
    }

    public function create(): View
    {
        $categories = PortfolioCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.portfolios.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'portfolio_category_id' => 'nullable|exists:portfolio_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolios,slug',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'completion_year' => 'nullable|string|max:10',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $this->uploadImage($request->file('main_image'), 'portfolios');
        }

        $portfolio = Portfolio::create($validated);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $galleryFile) {
                $imgPath = $this->uploadImage($galleryFile, 'portfolios/gallery');
                PortfolioImage::create([
                    'portfolio_id' => $portfolio->id,
                    'image_path' => $imgPath,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio proyek berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio): View
    {
        $categories = PortfolioCategory::orderBy('name')->get();
        $portfolio->load('images');
        return view('admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'portfolio_category_id' => 'nullable|exists:portfolio_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolios,slug,' . $portfolio->id,
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'completion_year' => 'nullable|string|max:10',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('main_image')) {
            $this->deleteImage($portfolio->main_image);
            $validated['main_image'] = $this->uploadImage($request->file('main_image'), 'portfolios');
        }

        $portfolio->update($validated);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $galleryFile) {
                $imgPath = $this->uploadImage($galleryFile, 'portfolios/gallery');
                PortfolioImage::create([
                    'portfolio_id' => $portfolio->id,
                    'image_path' => $imgPath,
                    'sort_order' => $portfolio->images()->count() + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $this->deleteImage($portfolio->main_image);

        foreach ($portfolio->images as $img) {
            $this->deleteImage($img->image_path);
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil dihapus.');
    }

    public function deleteGalleryImage(PortfolioImage $image): RedirectResponse
    {
        $this->deleteImage($image->image_path);
        $image->delete();

        return back()->with('success', 'Foto galeri portofolio berhasil dihapus.');
    }
}

