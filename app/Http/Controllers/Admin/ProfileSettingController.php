<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileSettingController extends Controller
{
    use HandlesImageUploads;

    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.profile', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'brand_title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'about_short' => 'nullable|string',
            'business_history' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'whatsapp_number' => 'required|string|max:30',
            'phone_number' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'service_areas' => 'nullable|string',
            'business_hours' => 'nullable|string',
            'google_maps_embed' => 'nullable|string',
            'instagram_url' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'tiktok_url' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'logo_dark' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'favicon' => 'nullable|mimes:jpeg,png,jpg,webp,svg,ico|max:2048',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'hero_badge_title' => 'nullable|string|max:255',
            'hero_badge_subtitle' => 'nullable|string|max:255',
            'hero_badge_tag' => 'nullable|string|max:255',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'about_badge_title' => 'nullable|string|max:255',
            'about_badge_desc' => 'nullable|string|max:255',
            'about_page_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'cta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'cta_title' => 'nullable|string|max:255',
            'cta_subtitle' => 'nullable|string|max:255',
            'years_experience' => 'nullable|string|max:50',
        ]);

        $fileKeys = ['logo', 'logo_dark', 'favicon', 'hero_image', 'about_image', 'about_page_image', 'cta_image'];
        foreach ($validated as $key => $value) {
            if (in_array($key, $fileKeys)) {
                continue;
            }
            Setting::set($key, $value);
        }

        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadImage($request->file('logo'), 'brand');
            Setting::set('logo_path', $logoPath, 'assets');
        }

        if ($request->hasFile('logo_dark')) {
            $logoDarkPath = $this->uploadImage($request->file('logo_dark'), 'brand');
            Setting::set('logo_dark_path', $logoDarkPath, 'assets');
        }

        if ($request->hasFile('favicon')) {
            $favPath = $this->uploadImage($request->file('favicon'), 'brand');
            Setting::set('favicon_path', $favPath, 'assets');
        }

        if ($request->hasFile('hero_image')) {
            $heroPath = $this->uploadImage($request->file('hero_image'), 'frontend');
            Setting::set('hero_image', $heroPath, 'frontend');
        }

        if ($request->hasFile('about_image')) {
            $aboutPath = $this->uploadImage($request->file('about_image'), 'frontend');
            Setting::set('about_image', $aboutPath, 'frontend');
        }

        if ($request->hasFile('about_page_image')) {
            $aboutPagePath = $this->uploadImage($request->file('about_page_image'), 'frontend');
            Setting::set('about_page_image', $aboutPagePath, 'frontend');
        }

        if ($request->hasFile('cta_image')) {
            $ctaPath = $this->uploadImage($request->file('cta_image'), 'frontend');
            Setting::set('cta_image', $ctaPath, 'frontend');
        }

        return back()->with('success', 'Profil dan informasi website berhasil diperbarui.');
    }
}

