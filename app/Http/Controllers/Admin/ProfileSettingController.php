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
        ]);

        foreach ($validated as $key => $value) {
            if (in_array($key, ['logo', 'logo_dark', 'favicon'])) {
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

        return back()->with('success', 'Profil dan informasi website berhasil diperbarui.');
    }
}

