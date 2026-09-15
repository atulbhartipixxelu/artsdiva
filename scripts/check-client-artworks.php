<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Artwork;
use App\Models\Artist;

$slugs = [
    'the-two-fridas',
    'self-portrait-with-monkey',
    'two-sisters-on-the-terrace',
    'flatford-mill-river-scene',
    'the-gleaners',
    'horses-1960',
    'galloping-horses',
    'nude-figure-with-cityscape',
    'village-path',
    'fields-near-a-village',
    'boulevard-montmartre',
    'pissarro-self-portrait',
    'woman-with-green-hat',
    'the-stone-breakers',
    'herd-of-horses',
];

foreach ($slugs as $slug) {
    $a = Artwork::where('slug', $slug)->first();
    if (!$a) {
        echo "MISSING artwork: {$slug}\n";
        continue;
    }
    $path = public_path($a->thumbnail);
    $ok = is_file($path) ? 'IMG_OK' : 'IMG_MISSING';
    echo "OK {$a->title} | {$a->slug} | {$a->year} | {$ok} | {$a->thumbnail}\n";
}

$p = Artist::where('slug', 'like', '%picasso%')->first();
if ($p) {
    $path = public_path($p->image);
    $ok = is_file($path) ? 'IMG_OK' : 'IMG_MISSING';
    echo "Artist Picasso | {$ok} | {$p->image}\n";
}
