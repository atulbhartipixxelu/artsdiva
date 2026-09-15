<?php
/**
 * Export master artwork list to docs/ (no credentials printed).
 * Usage: php scripts/export-artwork-master-list.php
 */
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Artwork;
use Illuminate\Support\Str;

$rows = Artwork::query()
    ->with('artist:id,name')
    ->orderByRaw("CASE WHEN serial_number IS NULL OR serial_number = '' THEN 1 ELSE 0 END")
    ->orderBy('serial_number')
    ->orderBy('id')
    ->get(['id', 'serial_number', 'title', 'description', 'artist_id', 'is_published']);

$docs = dirname(__DIR__).'/docs';
if (! is_dir($docs)) {
    mkdir($docs, 0755, true);
}

$mdPath = $docs.'/ARTWORK-MASTER-LIST.md';
$csvPath = $docs.'/ARTWORK-MASTER-LIST.csv';

$md = "# ArtsDiva — Artwork Master List\n\n";
$md .= '**Generated:** '.now()->toDateTimeString()."\n";
$md .= '**Total artworks:** '.$rows->count()."\n\n";
$md .= "This list is for intern handoff. Columns: Serial | Artist | Title | Description | Status.\n\n";
$md .= "| Serial | Artist | Title | Description | Status |\n";
$md .= "|--------|--------|-------|-------------|--------|\n";

$csv = fopen($csvPath, 'w');
fputcsv($csv, ['Serial number', 'Artist name', 'Title', 'Description', 'Published']);

foreach ($rows as $a) {
    $serial = $a->serial_number ?: '(none)';
    $artist = $a->artist?->name ?: '(no artist)';
    $title = $a->title ?: '';
    $desc = trim(preg_replace('/\s+/', ' ', (string) $a->description));
    $status = $a->is_published ? 'Active' : 'Inactive';

    $md .= '| '.str_replace('|', '\\|', $serial)
        .' | '.str_replace('|', '\\|', $artist)
        .' | '.str_replace('|', '\\|', $title)
        .' | '.str_replace('|', '\\|', $desc !== '' ? $desc : '—')
        .' | '.$status." |\n";

    fputcsv($csv, [$a->serial_number, $artist, $title, $a->description, $status]);
}

fclose($csv);
file_put_contents($mdPath, $md);

echo 'Exported '.$rows->count()." artworks\n";
echo "MD:  {$mdPath}\n";
echo "CSV: {$csvPath}\n";
