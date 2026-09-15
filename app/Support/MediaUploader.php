<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUploader
{
    public static function store(?UploadedFile $file, string $folder = 'uploads'): ?string
    {
        if (! $file) {
            return null;
        }

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $name.'-'.Str::random(6).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');

        return 'storage/'.$path;
    }
}
