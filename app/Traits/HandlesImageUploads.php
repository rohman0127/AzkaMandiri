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
    }
}

