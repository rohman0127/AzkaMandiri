<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioCategoryController extends Controller
{
    public function index(): View
    {
        $categories = PortfolioCategory::withCount('portfolios')->orderBy('sort_order')->get();
        return view('admin.portfolio-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.portfolio-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolio_categories,slug',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        PortfolioCategory::create($validated);

        return redirect()->route('admin.portfolio-categories.index')->with('success', 'Kategori portofolio berhasil ditambahkan.');
    }

    public function edit(PortfolioCategory $portfolioCategory): View
    {
        return view('admin.portfolio-categories.edit', compact('portfolioCategory'));
    }

    public function update(Request $request, PortfolioCategory $portfolioCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolio_categories,slug,' . $portfolioCategory->id,
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        $portfolioCategory->update($validated);

        return redirect()->route('admin.portfolio-categories.index')->with('success', 'Kategori portofolio berhasil diperbarui.');
    }

    public function destroy(PortfolioCategory $portfolioCategory): RedirectResponse
    {
        $portfolioCategory->delete();
        return redirect()->route('admin.portfolio-categories.index')->with('success', 'Kategori portofolio berhasil dihapus.');
    }
}

