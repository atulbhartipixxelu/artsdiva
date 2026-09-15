<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$prioritySlugs = [
    'the-two-fridas',
    'self-portrait-with-monkey',
    'untitled-horse',
    'horse-1960',
    'galloping-horses',
    'nude-figure-with-cityscape',
    'untitled-ufo-and-dogs',
    'radiant-figures-mural',
    'keith-haring-portrait',
    'boulevard-montmartre',
    'village-path',
    'fields-near-a-village',
    'pissarro-self-portrait',
];

// Push everything back first
App\Models\Artwork::query()->update(['is_featured' => false]);
App\Models\Artwork::query()->orderBy('id')->get()->each(function ($art, $i) {
    $art->update(['sort_order' => 1000 + $i]);
});

foreach ($prioritySlugs as $order => $slug) {
    $updated = App\Models\Artwork::where('slug', $slug)->update([
        'sort_order' => $order,
        'is_featured' => true,
    ]);
    echo ($updated ? 'OK' : 'MISS')." {$order}: {$slug}".PHP_EOL;
}

echo PHP_EOL.'Top catalogue order:'.PHP_EOL;
App\Models\Artwork::published()->orderBy('sort_order')->orderByDesc('id')->take(12)
    ->get(['sort_order', 'title', 'slug'])
    ->each(fn ($a) => print($a->sort_order.' | '.$a->title.PHP_EOL));
