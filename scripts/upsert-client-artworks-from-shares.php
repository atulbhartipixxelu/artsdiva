<?php

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
    'Frida Kahlo', 'Mexico City', 'Mexico',
    'images/catalogue/client-self-portrait-with-monkey.png',
    'Frida Kahlo (1907–1954) is among the most recognised figures in twentieth-century Mexican art.',
    0
);
$husain = upsertArtist(
    'M.F. Husain', 'Mumbai', 'India',
    'images/catalogue/artwork-036.png',
    'M.F. Husain (1915–2011) was a founding member of the Progressive Artists\' Group.',
    1
);
$picasso = upsertArtist(
    'Pablo Picasso', 'Malaga', 'Spain',
    'images/catalogue/client-pablo-picasso-portrait.png',
    'Pablo Picasso (1881–1973) reshaped modern art through Cubism and continual reinvention of form.',
    2
);
$renoir = upsertArtist(
    'Pierre-Auguste Renoir', 'Paris', 'France',
    'images/catalogue/client-two-sisters.png',
    'Pierre-Auguste Renoir (1841–1919) was a leading Impressionist known for luminous colour and scenes of leisure.',
    3
);
$constable = upsertArtist(
    'John Constable', 'Suffolk', 'UK',
    'images/catalogue/client-flatford-mill.png',
    'John Constable (1776–1837) painted Suffolk\'s working countryside with unusual attention to sky, water, and light.',
    4
);
$millet = upsertArtist(
    'Jean-François Millet', 'Barbizon', 'France',
    'images/catalogue/client-the-gleaners.png',
    'Jean-François Millet (1814–1875) depicted peasant labour with quiet dignity; The Gleaners is among his most reproduced works.',
    5
);
$courbet = upsertArtist(
    'Gustave Courbet', 'Ornans', 'France',
    'images/catalogue/artwork-014.png',
    'Gustave Courbet (1819–1877) helped found Realism by painting labour without idealisation.',
    6
);
$pissarro = upsertArtist(
    'Camille Pissarro', 'Paris', 'France',
    'images/catalogue/artwork-080.png',
    'Camille Pissarro (1830–1903) was a senior Impressionist known for rural life and Paris boulevard series.',
    7
);
$sisley = upsertArtist(
    'Alfred Sisley', 'Paris', 'France',
    'images/catalogue/artwork-081.png',
    'Alfred Sisley (1839–1899) devoted his career to landscape and shifting light.',
    8
);

$works = [
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
        'description' => "Painted following her divorce from Diego Rivera, this double self-portrait presents two versions of the artist seated side by side, hearts exposed and connected by a single vein. One Frida wears European dress, the other Tehuana costume, reflecting her dual heritage and the emotional rupture of the period. It stands among the most studied works of twentieth-century Mexican art.",
    ],
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
        'description' => "Kahlo frequently placed herself among animals and dense foliage, using them as both companions and symbolic guardians. The spider monkey at her shoulder and the red ribbon at her throat recur across several of her self-portraits from this period, each carrying personal and political undertones tied to her identity and physical suffering.",
    ],
    [
        'artist' => $renoir,
        'slug' => 'two-sisters-on-the-terrace',
        'title' => 'Two Sisters (On the Terrace)',
        'city' => 'Chatou',
        'category' => 'Figurative',
        'price_eur' => 55000,
        'dimensions' => '100.5 × 81 cm',
        'weight' => '8.0 kg',
        'year' => 1881,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/client-two-sisters.png',
        'description' => "Renoir painted this scene overlooking the Seine near Chatou, using two models rather than actual siblings to compose an image of youthful ease. Loose, luminous brushwork defines the flowers, the basket of yarn, and the soft light of a spring afternoon. It remains one of the most recognized examples of Renoir's Impressionist period.",
    ],
    [
        'artist' => $constable,
        'slug' => 'flatford-mill-river-scene',
        'title' => 'Flatford Mill (River Scene)',
        'city' => 'Suffolk',
        'category' => 'Landscape',
        'price_eur' => 48000,
        'dimensions' => '101.6 × 127 cm',
        'weight' => '10.0 kg',
        'year' => 1817,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/client-flatford-mill.png',
        'description' => "Constable's landscapes captured the working countryside of Suffolk with unusual attention to sky, water, and light. This canal scene, with its barge, towpath, and grazing horse, reflects his belief that ordinary rural labor deserved the same seriousness as historical or mythological subjects.",
    ],
    [
        'artist' => $millet,
        'slug' => 'the-gleaners',
        'title' => 'The Gleaners',
        'city' => 'Barbizon',
        'category' => 'Figurative',
        'price_eur' => 52000,
        'dimensions' => '83.5 × 110 cm',
        'weight' => '7.5 kg',
        'year' => 1857,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/client-the-gleaners.png',
        'description' => "Millet depicted three peasant women gathering leftover grain after the harvest, a task reserved for the rural poor. The painting's quiet dignity and its unflinching focus on labor made it controversial at the time, and it later became one of the most reproduced images of nineteenth-century French painting.",
    ],
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
        'description' => "Husain's horses are among the most recognized motifs in Indian modern art, rendered here in fractured white and black against a field of red. The horse recurs throughout his body of work as a symbol of energy and movement, drawing on both classical Indian sculpture and modernist abstraction.",
    ],
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
        'description' => "This composition brings together several horses in motion, each rendered in a distinct flat color and outlined in bold black line. Husain's treatment owes as much to Indian miniature painting as to European modernism, compressing multiple animals into a single dynamic field.",
    ],
    [
        'artist' => $husain,
        'slug' => 'galloping-horses',
        'title' => 'Galloping Horses',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 24500,
        'dimensions' => '122 × 152 cm',
        'weight' => '8.4 kg',
        'year' => null,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/artwork-048.png',
        'description' => "This composition brings together several horses in motion, each rendered in a distinct flat color and outlined in bold black line. Husain's treatment owes as much to Indian miniature painting as to European modernism, compressing multiple animals into a single dynamic field.",
    ],
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
        'description' => "Husain places a red female figure at the center of this work, her outstretched limbs connecting a wheel motif to place names including Delhi, Benaras, and Kolkata. The painting reflects his recurring interest in mapping the female form onto the geography and symbolism of India.",
    ],
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
        'description' => "Pissarro painted rural life around Pontoise and its surrounding villages with a steady, structured application of color. This path scene, framed by a leaning tree and whitewashed cottage, reflects his interest in everyday agricultural life rather than grand landscape drama.",
    ],
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
    [
        'artist' => $sisley,
        'slug' => 'fields-near-a-village',
        'title' => 'Fields near a Village',
        'city' => 'Paris',
        'category' => 'Landscape',
        'price_eur' => 22000,
        'dimensions' => '54 × 73 cm',
        'weight' => '3.5 kg',
        'year' => null,
        'medium' => 'Oil on canvas',
        'image' => 'images/catalogue/artwork-081.png',
        'description' => "Sisley's landscapes favored open sky and shifting light over incident or narrative. This view across cultivated fields toward a distant village shows his characteristic high horizon line and attention to cloud formation, qualities that set him apart within the Impressionist circle.",
    ],
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
        'description' => "Painted from an upper-floor window, this view captures the bustle of Parisian boulevard life in soft winter light. Pissarro produced a series of works from this vantage point, tracking the same street under changing weather and time of day.",
    ],
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
        'description' => "Pissarro presents himself in plain dress against a muted interior, his long beard and steady gaze rendered with the same careful brushwork he applied to his landscapes. The painting reflects his standing as a senior figure among the Impressionists, respected by peers including Cézanne and Gauguin.",
    ],
];

$sort = 0;
foreach ($works as $work) {
    $artist = $work['artist'];
    unset($work['artist']);
    $art = upsertArtwork($work, $artist, $sort);
    echo 'OK '.$sort.': '.$art->title.' ['.$art->slug.']'.PHP_EOL;
    $sort++;
}

// Align older horse records to Horses (1960)
$horse = Artwork::where('slug', 'horses-1960')->first()
    ?: Artwork::whereIn('slug', ['untitled-horse', 'horse-1960'])->orderBy('id')->first();
if ($horse) {
    $horse->update([
        'title' => 'Horses (1960)',
        'slug' => 'horses-1960',
        'year' => 1960,
        'artist_id' => $husain->id,
        'thumbnail' => 'images/catalogue/masters-0003-horses-1960.png',
        'gallery' => ['images/catalogue/masters-0003-horses-1960.png'],
        'sort_order' => 5,
        'is_featured' => true,
        'is_published' => true,
    ]);
    Artwork::whereIn('slug', ['untitled-horse', 'horse-1960', 'horse-1960-085', 'untitled-horse-085'])
        ->where('id', '!=', $horse->id)
        ->update(['title' => 'Horses (1960)', 'artist_id' => $husain->id, 'year' => 1960]);
    echo 'Aligned horse records to Horses (1960)'.PHP_EOL;
}

echo PHP_EOL.'Picasso portrait set on artist profile only (not Woman with Green Hat).'.PHP_EOL;
echo 'Client masters images applied for Kahlo / Husain / Pissarro shares.'.PHP_EOL;