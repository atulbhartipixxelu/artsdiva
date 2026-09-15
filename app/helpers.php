<?php

/**
 * Build a local ArtsDiva image asset path from an Unsplash-style photo id.
 */
if (! function_exists('ad_img')) {
    function ad_img(string $photoId): string
    {
        $photoId = preg_replace('/^photo-/', '', $photoId);

        return asset('images/photo-'.$photoId.'.jpg');
    }
}

/**
 * Resolve CMS / admin-entered paths under the app base (e.g. /dev/artsdiva).
 * Root paths like "/catalogue" must not hit the main domain.
 */
if (! function_exists('site_url')) {
    function site_url(?string $path, ?string $fallback = null): string
    {
        $path = trim((string) $path);
        if ($path === '') {
            return $fallback ?? url('/');
        }

        if (str_starts_with($path, '#')
            || str_starts_with($path, 'mailto:')
            || str_starts_with($path, 'tel:')
            || preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return url('/'.ltrim($path, '/'));
    }
}

/**
 * Keep pagination / absolute paths under APP_URL subdirectory (e.g. /dev/artsdiva).
 */
if (! function_exists('site_page_url')) {
    function site_page_url(?string $url): string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return '#';
        }

        $root = rtrim((string) config('app.url'), '/');
        if ($root === '') {
            return $url;
        }

        $rootPath = rtrim((string) (parse_url($root, PHP_URL_PATH) ?: ''), '/');
        if ($rootPath === '') {
            return $url;
        }

        $parts = parse_url($url);
        if ($parts === false) {
            return $url;
        }

        $path = $parts['path'] ?? '/';
        if (str_starts_with($path, $rootPath.'/') || $path === $rootPath) {
            return $url;
        }

        $fixed = $root.'/'.ltrim($path, '/');
        if (! empty($parts['query'])) {
            $fixed .= '?'.$parts['query'];
        }
        if (! empty($parts['fragment'])) {
            $fixed .= '#'.$parts['fragment'];
        }

        return $fixed;
    }
}
