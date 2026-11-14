<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryCategory::withCount('products')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->paginate(15)->withQueryString();

        return view('admin.inventory.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $count = 1;
        while (InventoryCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$originalSlug}-" . $count++;
        }

        InventoryCategory::create($validated);

        return redirect()->route('admin.inventory.categories.index')->with('success', 'Kategori produk berhasil ditambahkan.');
    }

    public function update(Request $request, InventoryCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        if ($category->name !== $validated['name']) {
            $newSlug = Str::slug($validated['name']);
            $originalSlug = $newSlug;
            $count = 1;
            while (InventoryCategory::where('slug', $newSlug)->where('id', '!=', $category->id)->exists()) {
                $newSlug = "{$originalSlug}-" . $count++;
            }
            $validated['slug'] = $newSlug;
        }

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->route('admin.inventory.categories.index')->with('success', 'Kategori produk berhasil diperbarui.');
    }

    public function destroy(InventoryCategory $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki relasi ke produk.');
        }

        $category->delete();

        return redirect()->route('admin.inventory.categories.index')->with('success', 'Kategori produk berhasil dihapus.');
    }
}

