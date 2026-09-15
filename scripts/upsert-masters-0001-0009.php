<?php

/**
 * Upsert ArtsDiva Masters serials 0001–0009 only.
 * Does NOT delete any existing artists/artworks.
 */

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Artist;
use App\Models\Artwork;
use Illuminate\Support\Str;

function upsertArtist(string $name, string $city, string $country, string $image, string $bio, int $sort): Artist
{
    $artist = Artist::firstOrNew(['slug' => Str::slug($name)]);
    $artist->fill([
        'name' => $name,
        'city' => $city,
        'country' => $country,
        'image' => $image,
        'bio' => $bio,
        'is_featured' => true,
        'is_published' => true,
        'sort_order' => $sort,
    ])->save();

    return $artist->fresh();
}

function upsertArtwork(array $data, Artist $artist, int $sort): Artwork
{
    $art = Artwork::firstOrNew(['slug' => $data['slug']]);
    $art->fill([
        'artist_id' => $artist->id,
        'title' => $data['title'],
        'slug' => $data['slug'],
        'serial_number' => $data['serial_number'] ?? null,
        'city' => $data['city'],
        'category' => $data['category'],
        'price_eur' => $data['price_eur'],
        'dimensions' => $data['dimensions'],
        'weight' => $data['weight'] ?? null,
        'year' => $data['year'],
        'medium' => $data['medium'],
        'description' => $data['description'],
        'thumbnail' => $data['image'],
        'gallery' => [$data['image']],
        'is_featured' => true,
        'is_published' => true,
        'sort_order' => $sort,
    ])->save();

    return $art->fresh();
}

$frida = upsertArtist(
    'Frida Kahlo',
    'Mexico City',
    'Mexico',
    'images/catalogue/masters-0002-self-portrait-with-monkey.png',
    'Frida Kahlo (1907–1954) is among the most recognised figures in twentieth-century Mexican art.',
    0
);

$husain = upsertArtist(
    'M.F. Husain',
    'Mumbai',
    'India',
    'images/catalogue/masters-0003-horses-1960.png',
    'M.F. Husain (1915–2011) was a founding member of the Progressive Artists\' Group.',
    1
);

$pissarro = upsertArtist(
    'Camille Pissarro',
    'Paris',
    'France',
    'images/catalogue/masters-0006-pissarro-self-portrait.png',
    'Camille Pissarro (1830–1903) was a senior Impressionist known for rural life and Paris boulevard series.',
    7
);

$works = [
    // 0001
    [
        'artist' => $frida,
        'slug' => 'the-two-fridas',
        'title' => 'The Two Fridas',
        'city' => 'Mexico City',
        'category' => 'Figurative',
        'price_eur' => 68000,
        'dimensions' => '173.5 × 173 cm',
        'weight' => '12.5 kg',
        'year' => 1939,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/masters-0001-the-two-fridas.png',
        'description' => 'Two identical women seated, holding hands, hearts exposed and connected by one vein, grey stormy sky background. Painted in 1939 following Kahlo\'s divorce from Diego Rivera.',
    ],
    // 0002
    [
        'artist' => $frida,
        'slug' => 'self-portrait-with-monkey',
        'title' => 'Self-Portrait with Monkey',
        'city' => 'Mexico City',
        'category' => 'Figurative',
        'price_eur' => 42000,
        'dimensions' => '40.6 × 30.5 cm',
        'weight' => '2.1 kg',
        'year' => 1938,
        'medium' => 'Oil on masonite',
        'image' => 'images/catalogue/masters-0002-self-portrait-with-monkey.png',
        'description' => 'Single woman with joined eyebrows, a small monkey on her shoulder, and a dense green leafy background. One of Kahlo\'s most recognised self-portraits from 1938.',
    ],
    // 0003
    [
        'artist' => $husain,
        'slug' => 'horses-1960',
        'title' => 'Horses (1960)',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 18500,
        'dimensions' => '91 × 122 cm',
        'weight' => '6.2 kg',
        'year' => 1960,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/masters-0003-horses-1960.png',
        'description' => 'One abstract horse in warm earth tones with bold black outlines and no rider — a signature Husain motif of energy and movement.',
    ],
    // 0004
    [
        'artist' => $husain,
        'slug' => 'herd-of-horses',
        'title' => 'Herd of Horses',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 24500,
        'dimensions' => '122 × 152 cm',
        'weight' => '8.4 kg',
        'year' => null,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/masters-0004-herd-of-horses.png',
        'description' => 'Multiple horses together mid-gallop, each painted in a different bold flat colour against a fiery red ground.',
    ],
    // 0005 (updates existing nude-figure-with-cityscape row if present)
    [
        'artist' => $husain,
        'slug' => 'nude-figure-with-cityscape',
        'title' => 'Untitled',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 28000,
        'dimensions' => '152 × 122 cm',
        'weight' => '9.1 kg',
        'year' => 2005,
        'medium' => 'Acrylic on canvas',
        'image' => 'images/catalogue/masters-0005-untitled-husain.png',
        'description' => 'Red nude figure with a white spoked wheel on the torso and Indian city names lettered across the body, set against a teal ground.',
    ],
    // 0006
    [
        'artist' => $pissarro,
        'slug' => 'pissarro-self-portrait',
        'title' => 'Self-Portrait',
        'city' => 'Paris',
        'category' => 'Figurative',
        'price_eur' => 38000,
        'dimensions' => '56 × 46 cm',
        'weight' => '3.2 kg',
        'year' => 1873,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/masters-0006-pissarro-self-portrait.png',
        'description' => 'Older bearded man in a head-and-shoulders portrait — Pissarro\'s 1873 self-portrait rendered with careful Impressionist brushwork.',
    ],
    // 0007
    [
        'artist' => $pissarro,
        'slug' => 'boulevard-montmartre',
        'title' => 'Boulevard Montmartre series',
        'city' => 'Paris',
        'category' => 'Landscape',
        'price_eur' => 52000,
        'dimensions' => '73 × 92 cm',
        'weight' => '4.6 kg',
        'year' => 1897,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/masters-0007-boulevard-montmartre.png',
        'description' => 'Aerial view of a busy Parisian street from Pissarro\'s 1897 Boulevard Montmartre series, tracking boulevard life under changing light.',
    ],
    // 0008 (updates existing village-path row if present)
    [
        'artist' => $pissarro,
        'slug' => 'village-path',
        'title' => 'Untitled landscape',
        'city' => 'Pontoise',
        'category' => 'Landscape',
        'price_eur' => 26500,
        'dimensions' => '55 × 46 cm',
        'weight' => '3.0 kg',
        'year' => null,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/masters-0008-untitled-landscape-cottage.png',
        'description' => 'Dirt path past a cottage with two walking figures and an autumn tree — a rural Impressionist landscape by Camille Pissarro.',
    ],
    // 0009
    [
        'artist' => $pissarro,
        'slug' => 'untitled-landscape-harvest',
        'title' => 'Untitled landscape',
        'city' => 'Éragny',
        'category' => 'Landscape',
        'price_eur' => 27500,
        'dimensions' => '54 × 65 cm',
        'weight' => '3.4 kg',
        'year' => null,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/masters-0009-untitled-landscape-harvest.png',
        'description' => 'Golden harvest field with a distant village under a blue sky — an open Impressionist landscape by Camille Pissarro.',
    ],
];

$sort = 0;
foreach ($works as $work) {
    $artist = $work['artist'];
    unset($work['artist']);
    if (empty($work['serial_number'])) {
        $work['serial_number'] = str_pad((string) ($sort + 1), 4, '0', STR_PAD_LEFT);
    }
    $art = upsertArtwork($work, $artist, $sort);
    echo 'OK '.$work['serial_number'].': '.$art->title.' ['.$art->slug.']'.PHP_EOL;
    $sort++;
}

echo PHP_EOL.'Masters 0001–0009 upsert complete. Existing content kept; only matching slugs updated + Herd of Horses / harvest landscape added if missing.'.PHP_EOL;
