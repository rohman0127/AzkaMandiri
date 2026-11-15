<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesImageUploads
{
    /**
     * Upload an image to the public storage disk.
     */
    protected function uploadImage(UploadedFile $file, string $folder = 'uploads'): string
    {
        $extension = $file->getClientOriginalExtension();
        $safeName = Str::random(24) . '_' . time() . '.' . $extension;
        $path = $file->storeAs($folder, $safeName, 'public');

        // Also mirror directly to public/storage for seamless static serving on shared hosts without symlinks
        try {
            $destDir = public_path('storage/' . $folder);
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0777, true);
            }
            @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
        } catch (\Throwable $e) {
            // Silently allow fallback route to serve if filesystem permission prevents copying
        }

        return '/storage/' . $path;
    }

    /**
     * Delete an existing image from public storage.
     */
    protected function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        // If path begins with /storage/ or storage/, strip it to get the relative disk path
        $cleanPath = preg_replace('/^\/?storage\//', '', $path);

        if (Storage::disk('public')->exists($cleanPath)) {
            Storage::disk('public')->delete($cleanPath);
        }

        $publicCopy = public_path('storage/' . $cleanPath);
        if (file_exists($publicCopy)) {
            @unlink($publicCopy);
        }
    }
}

