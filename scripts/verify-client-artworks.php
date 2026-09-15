<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$artists = App\Models\Artist::whereIn('name', [
    'Frida Kahlo', 'M.F. Husain', 'Keith Haring', 'Camille Pissarro', 'Alfred Sisley',
])->pluck('name');
echo 'Artists: '.$artists->implode(', ').PHP_EOL;

$slugs = [
    'the-two-fridas', 'self-portrait-with-monkey', 'untitled-horse', 'galloping-horses',
    'nude-figure-with-cityscape', 'untitled-ufo-and-dogs', 'radiant-figures-mural',
    'boulevard-montmartre', 'village-path', 'fields-near-a-village', 'pissarro-self-portrait',
];
foreach (App\Models\Artwork::with('artist')->whereIn('slug', $slugs)->orderBy('title')->get() as $a) {
    echo $a->title.' | '.$a->artist?->name.' | '.$a->year.PHP_EOL;
}
