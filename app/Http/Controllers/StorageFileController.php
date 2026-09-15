<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StorageFileController extends Controller
{
    /**
     * Serve uploaded media without relying on public/storage symlink (Hostinger-safe).
     */
    public function __invoke(Request $request, string $path): BinaryFileResponse
    {
        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');

        if ($path === '' || str_contains($path, '..')) {
            abort(404);
        }

        $candidates = [
            public_path('storage/'.$path),
            storage_path('app/public/'.$path),
        ];

        foreach ($candidates as $full) {
            if (is_file($full) && is_readable($full)) {
                return response()->file($full, [
                    'Cache-Control' => 'public, max-age=604800',
                ]);
            }
        }

        abort(404);
    }
}
