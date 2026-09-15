<?php

/**
 * Patch catalogue artworks with client-verified titles, artists, and descriptions.
 * Only updates rows whose images we have locally (no web downloads).
 */

$path = __DIR__.'/../config/artworks.php';
$items = require $path;

$works = [
    'images/catalogue/artwork-041.png' => [
        'id' => 'the-two-fridas',
        'slug' => 'the-two-fridas',
        'title' => 'The Two Fridas',
        'artist' => 'Frida Kahlo',
        'city' => 'Mexico City',
        'category' => 'Figurative',
        'price_eur' => 68000,
        'dimensions' => '173.5 × 173 cm',
        'weight' => '12.5 kg',
        'year' => 1939,
        'medium' => 'Oil on canvas',
        'description' => "Painted following her divorce from Diego Rivera, this double self-portrait presents two versions of the artist seated side by side, hearts exposed and connected by a single vein. One Frida wears European dress, the other Tehuana costume, reflecting her dual heritage and the emotional rupture of the period. It stands among the most studied works of twentieth-century Mexican art.",
    ],
    'images/catalogue/artwork-040.png' => [
        'id' => 'self-portrait-with-monkey',
        'slug' => 'self-portrait-with-monkey',
        'title' => 'Self-Portrait with Monkey',
        'artist' => 'Frida Kahlo',
        'city' => 'Mexico City',
        'category' => 'Figurative',
        'price_eur' => 42000,
        'dimensions' => '40.6 × 30.5 cm',
        'weight' => '2.1 kg',
        'year' => 1940,
        'medium' => 'Oil on masonite',
        'description' => "Kahlo frequently placed herself among animals and dense foliage, using them as both companions and symbolic guardians. The spider monkey at her shoulder and the red ribbon at her throat recur across several of her self-portraits from this period, each carrying personal and political undertones tied to her identity and physical suffering.",
    ],
    'images/catalogue/artwork-036.png' => [
        'id' => 'horse-1960',
        'slug' => 'horse-1960',
        'title' => 'Horse (1960)',
        'artist' => 'M.F. Husain',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 18500,
        'dimensions' => '91 × 122 cm',
        'weight' => '6.2 kg',
        'year' => 1960,
        'medium' => 'Oil on canvas',
        'description' => "Husain's horses are among the most recognized motifs in Indian modern art, rendered here in fractured white and black against a field of red. The horse recurs throughout his body of work as a symbol of energy and movement, drawing on both classical Indian sculpture and modernist abstraction.",
    ],
    'images/catalogue/artwork-048.png' => [
        'id' => 'galloping-horses',
        'slug' => 'galloping-horses',
        'title' => 'Galloping Horses',
        'artist' => 'M.F. Husain',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 24500,
        'dimensions' => '122 × 152 cm',
        'weight' => '8.4 kg',
        'year' => 2000,
        'medium' => 'Oil on canvas',
        'description' => "This composition brings together several horses in motion, each rendered in a distinct flat color and outlined in bold black line. Husain's treatment owes as much to Indian miniature painting as to European modernism, compressing multiple animals into a single dynamic field.",
    ],
    'images/catalogue/artwork-035.png' => [
        'id' => 'nude-figure-with-cityscape',
        'slug' => 'nude-figure-with-cityscape',
        'title' => 'Nude Figure with Cityscape',
        'artist' => 'M.F. Husain',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 28000,
        'dimensions' => '152 × 122 cm',
        'weight' => '9.1 kg',
        'year' => 2005,
        'medium' => 'Acrylic on canvas',
        'description' => "Husain places a red female figure at the center of this work, her outstretched limbs connecting a wheel motif to place names including Delhi, Benaras, and Kolkata. The painting reflects his recurring interest in mapping the female form onto the geography and symbolism of India.",
    ],
    'images/catalogue/artwork-002.png' => [
        'id' => 'untitled-ufo-and-dogs',
        'slug' => 'untitled-ufo-and-dogs',
        'title' => 'Untitled (UFO and Dogs)',
        'artist' => 'Keith Haring',
        'city' => 'New York',
        'category' => 'Contemporary',
        'price_eur' => 32000,
        'dimensions' => '100 × 100 cm',
        'weight' => '4.8 kg',
        'year' => 1982,
        'medium' => 'Acrylic on canvas',
        'description' => "Bold black outlines, flat colour, and kinetic energy lines define this work. Two of Haring's iconic dotted dog figures encounter a blue UFO casting a pink beam — a recurring motif from his early 1980s vocabulary that bridges street culture and Pop Art.",
    ],
    'images/catalogue/artwork-003.png' => [
        'id' => 'radiant-figures-mural',
        'slug' => 'radiant-figures-mural',
        'title' => 'Radiant Figures',
        'artist' => 'Keith Haring',
        'city' => 'New York',
        'category' => 'Contemporary',
        'price_eur' => 45000,
        'dimensions' => '300 × 500 cm',
        'weight' => '—',
        'year' => 1986,
        'medium' => 'Mural / acrylic on wall',
        'description' => "A densely packed composition of Haring's interlocking, faceless figures in teal, yellow, pink, lavender, and blue. Radiant energy lines and a TV-headed figure speak to media culture, collective movement, and the public mural language that made Haring a defining voice of 1980s street art.",
    ],
    'images/catalogue/artwork-001.png' => [
        'id' => 'keith-haring-portrait',
        'slug' => 'keith-haring-portrait',
        'title' => 'Artist Portrait',
        'artist' => 'Keith Haring',
        'city' => 'New York',
        'category' => 'Photography',
        'price_eur' => 4500,
        'dimensions' => '60 × 90 cm',
        'weight' => '1.8 kg',
        'year' => 1986,
        'medium' => 'Archival pigment print',
        'description' => "A documentary portrait of Keith Haring beside his signature line drawings. The image situates the artist within the graphic vocabulary — radiant figures, stepped forms, and bold contour — that defined his contribution to contemporary art.",
    ],
    'images/catalogue/artwork-080.png' => [
        'id' => 'pissarro-self-portrait',
        'slug' => 'pissarro-self-portrait',
        'title' => 'Self-Portrait',
        'artist' => 'Camille Pissarro',
        'city' => 'Paris',
        'category' => 'Figurative',
        'price_eur' => 38000,
        'dimensions' => '56 × 46 cm',
        'weight' => '3.2 kg',
        'year' => 1873,
        'medium' => 'Oil on canvas',
        'description' => "Pissarro presents himself in plain dress against a muted interior, his long beard and steady gaze rendered with the same careful brushwork he applied to his landscapes. The painting reflects his standing as a senior figure among the Impressionists, respected by peers including Cézanne and Gauguin.",
    ],
    'images/catalogue/artwork-081.png' => [
        'id' => 'fields-near-a-village',
        'slug' => 'fields-near-a-village',
        'title' => 'Fields near a Village',
        'artist' => 'Alfred Sisley',
        'city' => 'Paris',
        'category' => 'Landscape',
        'price_eur' => 22000,
        'dimensions' => '54 × 73 cm',
        'weight' => '3.5 kg',
        'year' => 1873,
        'medium' => 'Oil on canvas',
        'description' => "Sisley's landscapes favored open sky and shifting light over incident or narrative. This view across cultivated fields toward a distant village shows his characteristic high horizon line and attention to cloud formation, qualities that set him apart within the Impressionist circle.",
    ],
    'images/catalogue/artwork-082.png' => [
        'id' => 'village-path',
        'slug' => 'village-path',
        'title' => 'Village Path',
        'artist' => 'Camille Pissarro',
        'city' => 'Pontoise',
        'category' => 'Landscape',
        'price_eur' => 26500,
        'dimensions' => '55 × 46 cm',
        'weight' => '3.0 kg',
        'year' => 1875,
        'medium' => 'Oil on canvas',
        'description' => "Pissarro painted rural life around Pontoise and its surrounding villages with a steady, structured application of color. This path scene, framed by a leaning tree and whitewashed cottage, reflects his interest in everyday agricultural life rather than grand landscape drama.",
    ],
    'images/catalogue/artwork-083.png' => [
        'id' => 'boulevard-montmartre',
        'slug' => 'boulevard-montmartre',
        'title' => 'Boulevard Montmartre',
        'artist' => 'Camille Pissarro',
        'city' => 'Paris',
        'category' => 'Landscape',
        'price_eur' => 52000,
        'dimensions' => '73 × 92 cm',
        'weight' => '4.6 kg',
        'year' => 1897,
        'medium' => 'Oil on canvas',
        'description' => "Painted from an upper-floor window, this view captures the bustle of Parisian boulevard life in soft winter light. Pissarro produced a series of works from this vantage point, tracking the same street under changing weather and time of day.",
    ],
];

// Duplicate image aliases keep unique slugs but same metadata.
$alias = [
    'images/catalogue/artwork-087.png' => 'images/catalogue/artwork-041.png',
    'images/catalogue/artwork-088.png' => 'images/catalogue/artwork-040.png',
    'images/catalogue/artwork-085.png' => 'images/catalogue/artwork-036.png',
    'images/catalogue/artwork-084.png' => 'images/catalogue/artwork-048.png',
    'images/catalogue/artwork-086.png' => 'images/catalogue/artwork-035.png',
    'images/catalogue/artwork-062.png' => 'images/catalogue/artwork-002.png',
    'images/catalogue/artwork-061.png' => 'images/catalogue/artwork-003.png',
    'images/catalogue/artwork-063.png' => 'images/catalogue/artwork-001.png',
];

$count = 0;
foreach ($items as $i => &$row) {
    $thumb = $row['thumbnail'] ?? '';
    $src = $works[$thumb] ?? null;
    $fromAlias = false;
    if (! $src && isset($alias[$thumb])) {
        $src = $works[$alias[$thumb]];
        $fromAlias = true;
    }
    if (! $src) {
        continue;
    }

    $patch = $src;
    if ($fromAlias) {
        $num = preg_match('/artwork-(\d+)\.png/', $thumb, $m) ? $m[1] : (string) ($i + 1);
        $patch['id'] = $src['slug'].'-'.$num;
        $patch['slug'] = $src['slug'].'-'.$num;
    }

    foreach ($patch as $k => $v) {
        $row[$k] = $v;
    }
    $count++;
}
unset($row);

file_put_contents($path, "<?php\n\nreturn ".var_export($items, true).";\n");
echo "Updated {$count} artworks\n";
