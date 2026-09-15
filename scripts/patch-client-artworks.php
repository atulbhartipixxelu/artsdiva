<?php

$path = __DIR__ . '/../config/artworks.php';
$items = require $path;

$byThumb = [
    'images/catalogue/artwork-036.png' => [
        'id' => 'galloping-horse-in-red',
        'slug' => 'galloping-horse-in-red',
        'title' => 'Galloping Horse in Red',
        'artist' => 'M.F. Husain',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 18500,
        'dimensions' => '91 × 122 cm',
        'weight' => '6.2 kg',
        'year' => 1995,
        'medium' => 'Oil on canvas',
        'description' => "Horses were the single most enduring motif across M.F. Husain's six-decade career, appearing in his work from the 1950s through the 2000s. Rendered in his signature semi-abstract style, with sweeping, elongated forms and bold, expressive brushwork, his horses fuse the energy of Indian and Arabic folk traditions with a modern painterly language.\n\nFor Husain, the galloping horse was never simply an animal in motion. It stood for freedom, power and vitality, drawing on childhood memories of watching Muharram processions and the cavalry horses of his native Maharashtra. Set against a charged red ground, the horse in this work exemplifies the dynamism and unrestrained energy that made Husain's equine paintings among the most sought-after images in modern Indian art.",
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
        'year' => 1938,
        'medium' => 'Oil on masonite',
        'description' => "Commissioned in 1938 by A. Conger Goodyear, then president of the Museum of Modern Art in New York, this intimate self-portrait shows Kahlo with her pet spider monkey, Fulang-Chang, its arm draped affectionately around her shoulder. Monkeys appear across many of Kahlo's self-portraits and are widely read as stand-ins for the children she was unable to have.\n\nKahlo's steady, direct gaze is framed by her signature unbroken eyebrows and a pre-Columbian necklace, a deliberate nod to her Indigenous Mexican heritage rather than her German ancestry. The dense, verdant backdrop reinforces the painting's quiet, personal register. Composed in the frontal manner of nineteenth-century Mexican provincial portraiture, the work is held today in the Albright-Knox Art Gallery, Buffalo.",
    ],
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
        'description' => "Painted in the same year as her divorce from Diego Rivera, The Two Fridas is Frida Kahlo's first large-scale oil painting and remains one of the most recognised works of twentieth-century Mexican art. The double self-portrait depicts two seated versions of the artist holding hands before a stormy sky, their hearts exposed and joined by a single vein.\n\nOne Frida wears a Victorian-style white dress associated with the period before her marriage; the other wears traditional Tehuana dress, reflecting the Mexican identity she embraced through her relationship with Rivera. Read together, the two figures stage a meditation on heartbreak, duality, and the negotiation between her European and Mexican heritage. The painting was exhibited at the International Surrealist Exhibition in Mexico City in 1940 and today hangs in the Museo de Arte Moderno, Mexico City.",
    ],
    'images/catalogue/artwork-048.png' => [
        'id' => 'herd-of-horses',
        'slug' => 'herd-of-horses',
        'title' => 'Herd of Horses',
        'artist' => 'M.F. Husain',
        'city' => 'Mumbai',
        'category' => 'Figurative',
        'price_eur' => 24500,
        'dimensions' => '122 × 152 cm',
        'weight' => '8.4 kg',
        'year' => 2000,
        'medium' => 'Oil on canvas',
        'description' => "Husain returned to the horse as a subject across dozens of compositions, often depicting them in groups, thundering across the canvas in tight, overlapping formation. Each animal retains a distinct posture and character even within the herd, a technical signature that distinguishes his multi-horse works from simple repetition.\n\nThe recurring image draws on multiple sources at once: the war horses of Indian miniature painting, the mythic seven horses of the sun god Surya's chariot, and Husain's own recollection of the tonga and cavalry horses he observed as a boy. Executed with the bold, gestural strokes and vivid palette that define his mature style, Herd of Horses captures the grace and controlled chaos that made the motif inseparable from Husain's identity as an artist.",
    ],
];

$alias = [
    'images/catalogue/artwork-085.png' => 'images/catalogue/artwork-036.png',
    'images/catalogue/artwork-088.png' => 'images/catalogue/artwork-040.png',
    'images/catalogue/artwork-087.png' => 'images/catalogue/artwork-041.png',
    'images/catalogue/artwork-084.png' => 'images/catalogue/artwork-048.png',
];

$count = 0;
foreach ($items as $i => &$row) {
    $thumb = $row['thumbnail'] ?? '';
    $src = $byThumb[$thumb] ?? null;
    $fromAlias = false;
    if (! $src && isset($alias[$thumb])) {
        $src = $byThumb[$alias[$thumb]];
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
