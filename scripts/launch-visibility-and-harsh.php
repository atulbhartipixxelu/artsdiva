<?php

/**
 * Launch readiness:
 * - ensure is_visible exists / all false
 * - hide dummy exhibitions & events from public
 * - create Harsh admin for data entry
 * - re-run Haring cleanup
 *
 * Usage:
 *   HARSH_ADMIN_PASSWORD='StrongPassHere12!' php scripts/launch-visibility-and-harsh.php
 */
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

echo "=== Launch visibility + Harsh admin ===\n";

if (! Schema::hasColumn('artworks', 'is_visible')) {
    fwrite(STDERR, "Run migrations first: php artisan migrate --force\n");
    exit(1);
}

$hidden = Artwork::query()->update(['is_visible' => false]);
echo "Artworks set is_visible=false: {$hidden}\n";

$ex = Exhibition::query()->update(['is_published' => false]);
$ev = Event::query()->update(['is_published' => false]);
echo "Exhibitions unpublished: {$ex}\n";
echo "Events unpublished: {$ev}\n";

// Remove public Haring / Crimson risk content (records deleted — Deep urgent)
require __DIR__.'/urgent-haring-and-location-fix.php';

$harshPass = getenv('HARSH_ADMIN_PASSWORD') ?: null;
if (! $harshPass || strlen($harshPass) < 12) {
    fwrite(STDERR, "Set HARSH_ADMIN_PASSWORD (min 12 chars) to create/update Harsh admin.\n");
} else {
    $harsh = User::query()->firstOrNew(['email' => 'harsh@artsdiva.art']);
    $harsh->fill([
        'name' => 'Harsh',
        'role' => User::ROLE_ADMIN,
        'is_active' => true,
        'password' => Hash::make($harshPass),
    ])->save();
    echo "Harsh admin ready: harsh@artsdiva.art\n";
}

$listed = Artwork::listed()->count();
echo "Public listed artworks now: {$listed} (should be 0 until Visible is switched on)\n";
echo "Done.\n";
