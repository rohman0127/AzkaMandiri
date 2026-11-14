<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoSettingController extends Controller
{
    use HandlesImageUploads;

    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.seo', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'meta_keywords' => 'nullable|string',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'custom_robots_txt' => 'nullable|string',
        ]);

        Setting::set('meta_title', $validated['meta_title'], 'seo');
        Setting::set('meta_description', $validated['meta_description'], 'seo');
        Setting::set('meta_keywords', $validated['meta_keywords'] ?? '', 'seo');

        if (isset($validated['custom_robots_txt'])) {
            Setting::set('custom_robots_txt', $validated['custom_robots_txt'], 'seo');
        }

        if ($request->hasFile('og_image')) {
            $ogPath = $this->uploadImage($request->file('og_image'), 'seo');
            Setting::set('og_image_path', $ogPath, 'seo');
        }

        return back()->with('success', 'Pengaturan SEO dan Open Graph berhasil diperbarui.');
    }
}

