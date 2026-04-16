<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function handleFileUpload(Request $request, string $fieldName, ?string $oldPath = null, string $directory = 'uploads'): ?string
    {
        if (! $request->hasFile($fieldName)) {
            return $oldPath;
        }

        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file($fieldName)->store($directory, 'public');
    }

    public function handleFileRemoval(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
