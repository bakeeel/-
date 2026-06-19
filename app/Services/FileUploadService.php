<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadAvatar(UploadedFile $file): string
    {
        // تخزين في مجلد عسكري خاص ومشفر الاسم
        $filename = 'mil_avatar_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('avatars', $filename, 'public');
    }

    public function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}