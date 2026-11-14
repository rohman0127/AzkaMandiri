<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceImage;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $query = Service::with('category')->orderBy('sort_order');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('service_category_id', $categoryId);
        }

        $services = $query->paginate(10)->withQueryString();
        $categories = ServiceCategory::orderBy('name')->get();

        return view('admin.services.index', compact('services', 'categories'));
    }

    public function create(): View
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_category_id' => 'nullable|exists:service_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'price_info' => 'nullable|string|max:255',
            'features' => 'nullable|string', // comma or newline separated
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        // Parse features into array
        if (!empty($validated['features'])) {
            $validated['features'] = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $validated['features']))));
        } else {
            $validated['features'] = [];
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->uploadImage($request->file('thumbnail'), 'services');
        }

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $this->uploadImage($request->file('main_image'), 'services');
        }

        $service = Service::create($validated);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $galleryFile) {
                $imgPath = $this->uploadImage($galleryFile, 'services/gallery');
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image_path' => $imgPath,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dibuat.');
    }

    public function edit(Service $service): View
    {
        $categories = ServiceCategory::orderBy('name')->get();
        $service->load('images');
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'service_category_id' => 'nullable|exists:service_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'price_info' => 'nullable|string|max:255',
            'features' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        if (!empty($validated['features'])) {
            $validated['features'] = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $validated['features']))));
        } else {
            $validated['features'] = [];
        }

        if ($request->hasFile('thumbnail')) {
            $this->deleteImage($service->thumbnail);
            $validated['thumbnail'] = $this->uploadImage($request->file('thumbnail'), 'services');
        }

        if ($request->hasFile('main_image')) {
            $this->deleteImage($service->main_image);
            $validated['main_image'] = $this->uploadImage($request->file('main_image'), 'services');
        }

        $service->update($validated);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $galleryFile) {
                $imgPath = $this->uploadImage($galleryFile, 'services/gallery');
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image_path' => $imgPath,
                    'sort_order' => $service->images()->count() + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->deleteImage($service->thumbnail);
        $this->deleteImage($service->main_image);

        foreach ($service->images as $img) {
            $this->deleteImage($img->image_path);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    public function deleteGalleryImage(ServiceImage $image): RedirectResponse
    {
        $this->deleteImage($image->image_path);
        $image->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}

