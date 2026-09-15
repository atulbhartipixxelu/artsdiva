<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Artist;
use App\Models\Artwork;
use Illuminate\Support\Str;

$artists = [
    ['Pablo Picasso', 'Malaga', 'Spain', 'images/catalogue/artwork-080.png', 'Pablo Picasso (1881–1973) was a Spanish painter and sculptor whose Cubist innovations reshaped twentieth-century art. His fractured planes and multiple viewpoints remain foundational for modern figurative painting.'],
    ['Pierre-Auguste Renoir', 'Paris', 'France', 'images/catalogue/artwork-081.png', 'Pierre-Auguste Renoir (1841–1919) was a leading Impressionist, celebrated for luminous colour and scenes of leisure. Works such as Two Sisters (On the Terrace) exemplify his soft light and youthful ease.'],
    ['John Constable', 'Suffolk', 'UK', 'images/catalogue/artwork-082.png', 'John Constable (1776–1837) painted the working countryside of Suffolk with unusual attention to sky, water, and light, treating ordinary rural labour with the seriousness once reserved for history painting.'],
    ['Gustave Courbet', 'Ornans', 'France', 'images/catalogue/artwork-014.png', 'Gustave Courbet (1819–1877) helped found Realism by painting labour and everyday life without idealisation. The Stone Breakers became a defining image of that rejection of academic subject matter.'],
    ['Jean-François Millet', 'Barbizon', 'France', 'images/catalogue/artwork-034.png', 'Jean-François Millet (1814–1875) depicted peasant labour with quiet dignity. The Gleaners remains among the most reproduced images of nineteenth-century French painting.'],
    ['Frida Kahlo', 'Mexico City', 'Mexico', 'images/catalogue/artwork-040.png', 'Frida Kahlo (1907–1954) is among the most recognised figures in twentieth-century Mexican art. Her self-portraits stage personal and political identity through symbolism and an unflinching gaze.'],
    ['M.F. Husain', 'Mumbai', 'India', 'images/catalogue/artwork-036.png', 'M.F. Husain (1915–2011) was a founding member of the Progressive Artists\' Group. His semi-abstract figurative language — especially the horse — fused folk memory, myth, and bold colour.'],
    ['Camille Pissarro', 'Paris', 'France', 'images/catalogue/artwork-080.png', 'Camille Pissarro (1830–1903) was a senior Impressionist, respected by Cézanne and Gauguin. He painted rural paths, villages, and Paris boulevards with structured colour.'],
    ['Alfred Sisley', 'Paris', 'France', 'images/catalogue/artwork-081.png', 'Alfred Sisley (1839–1899) devoted his career almost entirely to landscape, favouring open sky, shifting light, and high horizons.'],
];

foreach ($artists as $i => [$name, $city, $country, $img, $bio]) {
    $artist = Artist::firstOrNew(['slug' => Str::slug($name)]);
    $artist->fill([
        'name' => $name,
        'city' => $city,
        'country' => $country,
        'image' => $img,
        'bio' => $bio,
        'is_featured' => true,
        'is_published' => true,
        'sort_order' => $i,
    ]);
    $artist->save();
    echo 'Artist: '.$name.PHP_EOL;
}

$works = [
    [
        'slugs' => ['the-two-fridas', 'the-two-fridas-087'],
        'title' => 'The Two Fridas',
        'artist' => 'Frida Kahlo',
        'year' => 1939,
        'city' => 'Mexico City',
        'category' => 'Figurative',
        'medium' => 'Oil on canvas',
        'dimensions' => '173.5 × 173 cm',
        'price_eur' => 68000,
        'description' => "Painted following her divorce from Diego Rivera, this double self-portrait presents two versions of the artist seated side by side, hearts exposed and connected by a single vein. One Frida wears European dress, the other Tehuana costume, reflecting her dual heritage and the emotional rupture of the period. It stands among the most studied works of twentieth-century Mexican art.",
    ],
    [
        'slugs' => ['self-portrait-with-monkey', 'self-portrait-with-monkey-088'],
        'title' => 'Self-Portrait with Monkey',
        'artist' => 'Frida Kahlo',
        'year' => 1940,
        'city' => 'Mexico City',
        'category' => 'Figurative',
        'medium' => 'Oil on masonite',
        'dimensions' => '40.6 × 30.5 cm',
        'price_eur' => 42000,
        'description' => "Kahlo frequently placed herself among animals and dense foliage, using them as both companions and symbolic guardians. The spider monkey at her shoulder and the red ribbon at her throat recur across several of her self-portraits from this period, each carrying personal and political undertones tied to her identity and physical suffering.",
    ],
    [
        'slugs' => ['horse-1960', 'horse-1960-085', 'untitled-horse', 'untitled-horse-085'],
        'title' => 'Untitled (Horse)',
        'artist' => 'M.F. Husain',
        'year' => null,
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'medium' => 'Oil on canvas',
        'dimensions' => '91 × 122 cm',
        'price_eur' => 18500,
        'description' => "Husain's horses are among the most recognized motifs in Indian modern art, rendered here in fractured white and black against a field of red. The horse recurs throughout his body of work as a symbol of energy and movement, drawing on both classical Indian sculpture and modernist abstraction.",
        'preferred_slug' => 'untitled-horse',
    ],
    [
        'slugs' => ['galloping-horses', 'galloping-horses-084', 'herd-of-horses'],
        'title' => 'Galloping Horses',
        'artist' => 'M.F. Husain',
        'year' => null,
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'medium' => 'Oil on canvas',
        'dimensions' => '122 × 152 cm',
        'price_eur' => 24500,
        'description' => "This composition brings together several horses in motion, each rendered in a distinct flat color and outlined in bold black line. Husain's treatment owes as much to Indian miniature painting as to European modernism, compressing multiple animals into a single dynamic field.",
    ],
    [
        'slugs' => ['nude-figure-with-cityscape', 'nude-figure-with-cityscape-086'],
        'title' => 'Nude Figure with Cityscape',
        'artist' => 'M.F. Husain',
        'year' => null,
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'medium' => 'Acrylic on canvas',
        'dimensions' => '152 × 122 cm',
        'price_eur' => 28000,
        'description' => "Husain places a red female figure at the center of this work, her outstretched limbs connecting a wheel motif to place names including Delhi, Benaras, and Kolkata. The painting reflects his recurring interest in mapping the female form onto the geography and symbolism of India.",
    ],
    [
        'slugs' => ['village-path'],
        'title' => 'Village Path',
        'artist' => 'Camille Pissarro',
        'year' => null,
        'city' => 'Pontoise',
        'category' => 'Landscape',
        'medium' => 'Oil on canvas',
        'dimensions' => '55 × 46 cm',
        'price_eur' => 26500,
        'description' => "Pissarro painted rural life around Pontoise and its surrounding villages with a steady, structured application of color. This path scene, framed by a leaning tree and whitewashed cottage, reflects his interest in everyday agricultural life rather than grand landscape drama.",
    ],
    [
        'slugs' => ['fields-near-a-village'],
        'title' => 'Fields near a Village',
        'artist' => 'Alfred Sisley',
        'year' => null,
        'city' => 'Paris',
        'category' => 'Landscape',
        'medium' => 'Oil on canvas',
        'dimensions' => '54 × 73 cm',
        'price_eur' => 22000,
        'description' => "Sisley's landscapes favored open sky and shifting light over incident or narrative. This view across cultivated fields toward a distant village shows his characteristic high horizon line and attention to cloud formation, qualities that set him apart within the Impressionist circle.",
    ],
    [
        'slugs' => ['boulevard-montmartre'],
        'title' => 'Boulevard Montmartre',
        'artist' => 'Camille Pissarro',
        'year' => 1897,
        'city' => 'Paris',
        'category' => 'Landscape',
        'medium' => 'Oil on canvas',
        'dimensions' => '73 × 92 cm',
        'price_eur' => 52000,
        'description' => "Painted from an upper-floor window, this view captures the bustle of Parisian boulevard life in soft winter light. Pissarro produced a series of works from this vantage point, tracking the same street under changing weather and time of day.",
    ],
    [
        'slugs' => ['pissarro-self-portrait'],
        'title' => 'Self-Portrait',
        'artist' => 'Camille Pissarro',
        'year' => 1873,
        'city' => 'Paris',
        'category' => 'Figurative',
        'medium' => 'Oil on canvas',
        'dimensions' => '56 × 46 cm',
        'price_eur' => 38000,
        'description' => "Pissarro presents himself in plain dress against a muted interior, his long beard and steady gaze rendered with the same careful brushwork he applied to his landscapes. The painting reflects his standing as a senior figure among the Impressionists, respected by peers including Cézanne and Gauguin.",
    ],
];

$order = 0;
foreach ($works as $work) {
    $artist = Artist::where('name', $work['artist'])->first();
    $updated = false;
    foreach ($work['slugs'] as $slug) {
        $art = Artwork::where('slug', $slug)->first();
        if (! $art) {
            continue;
        }
        $payload = [
            'title' => $work['title'],
            'artist_id' => $artist?->id,
            'city' => $work['city'],
            'category' => $work['category'],
            'medium' => $work['medium'],
            'dimensions' => $work['dimensions'],
            'price_eur' => $work['price_eur'],
            'description' => $work['description'],
            'year' => $work['year'],
            'is_featured' => true,
            'is_published' => true,
            'sort_order' => $order,
        ];
        if (! empty($work['preferred_slug']) && $slug === $work['slugs'][0]) {
            $payload['slug'] = $work['preferred_slug'];
        }
        $art->update($payload);
        $updated = true;
        echo 'Updated: '.$work['title'].' ('.$slug.')'.PHP_EOL;
        break; // update primary only; duplicates keep old slug but we can update all
    }
    // update all matching slugs
    foreach ($work['slugs'] as $i => $slug) {
        if ($i === 0) {
            continue;
        }
        $art = Artwork::where('slug', $slug)->first();
        if (! $art) {
            continue;
        }
        $art->update([
            'title' => $work['title'],
            'artist_id' => $artist?->id,
            'city' => $work['city'],
            'category' => $work['category'],
            'medium' => $work['medium'],
            'dimensions' => $work['dimensions'],
            'price_eur' => $work['price_eur'],
            'description' => $work['description'],
            'year' => $work['year'],
            'is_featured' => true,
            'is_published' => true,
            'sort_order' => 100 + $order,
        ]);
        echo 'Updated dup: '.$slug.PHP_EOL;
    }
    if (! $updated) {
        echo 'MISSING artwork for: '.$work['title'].PHP_EOL;
    }
    $order++;
}

echo PHP_EOL.'Done. Missing image works still need client photos:'.PHP_EOL;
echo "- Woman with Green Hat (Picasso)\n- Two Sisters (On the Terrace) (Renoir)\n- Flatford Mill (Constable)\n- The Stone Breakers (Courbet)\n- The Gleaners (Millet)\n";
