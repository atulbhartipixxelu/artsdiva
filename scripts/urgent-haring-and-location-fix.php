<?php

/**
 * Urgent live cleanup: remove Keith Haring / Crimson Veil Diptych risk listings.
 * Also sync placeholder artwork city from artist city (fixes Mumbai+USA style pairs).
 *
 * Usage (PHP 8.3 on Hostinger):
 *   /opt/alt/php83/usr/bin/php scripts/urgent-haring-and-location-fix.php
 */
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Artist;
use App\Models\Artwork;
use Illuminate\Support\Facades\DB;

echo "=== Urgent Haring / Crimson Veil cleanup ===\n";

$removedArtworks = 0;

$artworkQuery = Artwork::query()
    ->where(function ($q) {
        $q->where('title', 'like', '%Crimson Veil%')
            ->orWhere('serial_number', 'AD-0001')
            ->orWhere('slug', 'like', '%crimson-veil%');
    });

foreach ($artworkQuery->get() as $art) {
    echo "Removing artwork #{$art->id} [{$art->serial_number}] {$art->title}\n";
    $art->delete();
    $removedArtworks++;
}

// Any remaining works attributed to Keith Haring artist record
$haring = Artist::query()
    ->where('name', 'like', '%Keith Haring%')
    ->orWhere('slug', 'like', '%keith-haring%')
    ->get();

foreach ($haring as $artist) {
    $count = $artist->artworks()->count();
    echo "Unpublishing/removing artist #{$artist->id} {$artist->name} (slug={$artist->slug}) with {$count} works\n";
    foreach ($artist->artworks as $art) {
        echo "  - removing artwork #{$art->id} [{$art->serial_number}] {$art->title}\n";
        $art->delete();
        $removedArtworks++;
    }
    $artist->delete();
}

// If Aisha Rahman slug still shows Haring content somehow — restore safe unpublished state
$aisha = Artist::query()->where('slug', 'aisha-rahman')->first();
if ($aisha && str_contains(strtolower($aisha->name), 'haring')) {
    echo "Fixing aisha-rahman record that was renamed to Haring...\n";
    $aisha->update([
        'name' => 'Aisha Rahman',
        'city' => $aisha->city ?: 'Mumbai',
        'country' => $aisha->country && ! str_contains(strtolower($aisha->country), 'us') ? $aisha->country : 'India',
        'image' => null,
        'bio' => null,
        'is_published' => false,
        'is_featured' => false,
    ]);
}

echo "Artworks removed: {$removedArtworks}\n";

echo "\n=== Sync artwork.city from artist.city (placeholder AD-* only) ===\n";
$updated = 0;
Artwork::query()
    ->with('artist')
    ->where('serial_number', 'like', 'AD-%')
    ->orderBy('id')
    ->chunkById(50, function ($rows) use (&$updated) {
        foreach ($rows as $art) {
            if (! $art->artist || blank($art->artist->city)) {
                continue;
            }
            if ($art->city !== $art->artist->city) {
                $art->city = $art->artist->city;
                $art->save();
                $updated++;
            }
        }
    });

echo "Artwork cities synced: {$updated}\n";
echo "Done.\n";
