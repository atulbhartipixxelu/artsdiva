<?php

/**
 * Generates config/artworks.php for the 88 local catalogue images.
 */

$catalog = [
    1 => ['Crimson Veil Diptych', 'Abstract', 'Twin panels of layered crimson texture framed as a bold living-room statement.', 420],
    2 => ['Scarlet Cascade', 'Abstract', 'Vertical drips of saturated red create a dramatic, high-energy wall presence.', 380],
    3 => ['Urban Ember Pair', 'Abstract', 'Weathered red and ochre textures presented as a gallery-style matched pair.', 890],
    4 => ['Magenta Industrial Duo', 'Abstract', 'Hot magenta industrial textures in slim metallic frames for modern bedrooms.', 320],
    5 => ['Lunar Sphere Study I', 'Contemporary', 'Recessed circular form with a cratered metallic orb against deep black.', 540],
    6 => ['Lunar Sphere Study II', 'Contemporary', 'Square recess framing a textured silver sphere for architectural interiors.', 540],
    7 => ['Terracotta Horizon Set', 'Abstract', 'Warm burgundy and ochre abstracts in wide white mats with bronze frames.', 460],
    8 => ['Gallery Crimson No. 1', 'Abstract', 'Deep red abstract with multi-layer matting shown in a museum-style setting.', 1250],
    9 => ['Cure for Sadness', 'Abstract', 'Vertical crimson drips in walnut framing, inspired by colour as emotion.', 850],
    10 => ['The Eclipse Disc', 'Minimal', 'Hammered circular steel disc set in a square monochrome frame.', 185],
    11 => ['Midnight Zen Bowl', 'Object', 'Matte black ceramic bowl with a reflective hammered interior—art for the table.', 48],
    12 => ['Spirit of Bharat', 'Contemporary', 'Bold figurative composition celebrating cities, symbols, and national spirit.', 2800],
    13 => ['Crimson Gallop', 'Figurative', 'A single horse in cream and black linework against a fiery red field.', 780],
    14 => ['The Twin Portraits', 'Figurative', 'Surreal double-portrait print exploring dual identity and emotional bond.', 220],
    15 => ['Jungle Empress', 'Figurative', 'Portrait with red ribbons and a companion monkey amid tropical foliage.', 265],
    16 => ['Equine Stampede', 'Figurative', 'Multicolour herd in motion—expressionist energy for large walls.', 920],
    17 => ['Fragmented Red Wall', 'Abstract', 'Macro peeling paint in crimson, white, and charcoal—industrial poetry.', 310],
    18 => ['Vertical Red Pulse', 'Abstract', 'Tall crimson drip painting in a slim modern frame.', 295],
    19 => ['Ember Textures A', 'Abstract', 'Close-up weathered crimson surface for collectors of material abstraction.', 340],
    20 => ['Ember Textures B', 'Abstract', 'Companion weathered field with burnt orange flecks and deep shadow.', 340],
];

$titles = [
    'Amber Fracture', 'Silent Magenta', 'Copper Drift', 'Velvet Fault Line', 'Oxide Bloom',
    'Noir Horizon', 'Saffron Pulse', 'Ash and Rose', 'Marble Whisper', 'Ink Tide',
    'Golden Fault', 'Cobalt Residue', 'Ivory Storm', 'Rust Sonata', 'Pearl Geometry',
    'Smoke Lattice', 'Coral Archive', 'Graphite Bloom', 'Sienna Echo', 'Ivory Fault',
    'Terra Vein', 'Blush Concrete', 'Night Petal', 'Copper Veil', 'Obsidian Wash',
    'Cinnabar Field', 'Dove Geometry', 'Flame Residue', 'Slate Orchid', 'Bronze Mist',
    'Cherry Oxide', 'Pale Ember', 'Iron Blossom', 'Soft Geometry', 'Verdant Shadow',
    'Ruby Driftwood', 'Quiet Alloy', 'Sandstone Flame', 'Mercury Bloom', 'Linen Eclipse',
    'Cardinal Grain', 'Pewter Orchid', 'Warm Fracture', 'Ash Petal', 'Copper Lattice',
    'Scarlet Archive', 'Fog and Iron', 'Desert Ink', 'Rose Oxide', 'Midnight Clay',
    'Amber Lattice', 'Ivory Residue', 'Crimson Grain', 'Soft Oxide', 'Noir Petal',
    'Gilded Ash', 'Terra Pulse', 'Velvet Oxide', 'Silver Drift', 'Flame Archive',
    'Pale Cinnabar', 'Stone Blush', 'Echo Magenta', 'Quiet Scarlet', 'Alloy Garden',
    'Burnt Linen', 'Red Concrete', 'Shadow Coral', 'Matte Flame', 'Porcelain Rust',
];

$cities = ['Mumbai', 'Delhi', 'Paris', 'Milan', 'Berlin', 'Tokyo', 'New York', 'London', 'Dubai', 'Singapore', 'Jaipur', 'Barcelona'];
$categories = ['Abstract', 'Contemporary', 'Figurative', 'Minimal', 'Photography', 'Mixed Media'];
$mediums = [
    'Acrylic on canvas',
    'Oil on canvas',
    'Mixed media on panel',
    'Archival pigment print',
    'Giclée on cotton paper',
    'Textured acrylic on board',
    'Digital print on canvas',
];
$dims = ['60 × 90 cm', '80 × 80 cm', '100 × 100 cm', '120 × 80 cm', '70 × 100 cm', '90 × 120 cm', '50 × 70 cm', '140 × 90 cm'];

$artists = [
    'Aisha Rahman', 'Luca Moretti', 'Priya Kapoor', 'Noah Bennett', 'Hana Suzuki',
    'Omar Farid', 'Clara Weiss', 'Rohan Mehta', 'Isla Quinn', 'Diego Alvarez',
    'Mei Zhou', 'Samir Patel', 'Freya Olsen', 'Kenji Sato', 'Amara Nwosu',
    'Leo Hartmann', 'Yara Haddad', 'Felix Braun', 'Ananya Iyer', 'Mateo Rossi',
];

$descriptions = [
    'A refined statement piece balancing colour, texture, and quiet drama for modern interiors.',
    'Collector-ready wall art with layered surfaces and a gallery-quality presentation.',
    'Designed for bright living spaces seeking a bold yet sophisticated focal point.',
    'An ArtsDiva exclusive listing with versatile scale for residential or boutique commercial placement.',
    'Rich material presence and carefully balanced composition for curated collections.',
    'Ideal for leasing programmes and acquisition clients seeking contemporary impact.',
];

$rows = [];
$titleIdx = 0;

for ($i = 1; $i <= 88; $i++) {
    $num = str_pad((string) $i, 3, '0', STR_PAD_LEFT);
    $path = "images/catalogue/artwork-{$num}.png";

    if (isset($catalog[$i])) {
        [$title, $category, $description, $price] = $catalog[$i];
    } else {
        $title = $titles[$titleIdx % count($titles)];
        if ($titleIdx >= count($titles)) {
            $title .= ' '.($titleIdx - count($titles) + 2);
        }
        $titleIdx++;
        $category = $categories[$i % count($categories)];
        $description = $descriptions[$i % count($descriptions)];
        $price = [180, 220, 275, 320, 385, 450, 520, 640, 780, 890, 1100, 1450][$i % 12];
    }

    $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
    $slug = trim($slug, '-').'-'.$num;

    $rows[] = [
        'id' => $slug,
        'slug' => $slug,
        'title' => $title,
        'artist' => $artists[($i - 1) % count($artists)],
        'city' => $cities[($i - 1) % count($cities)],
        'category' => $category ?? $categories[$i % count($categories)],
        'price_eur' => (int) $price,
        'dimensions' => $dims[($i - 1) % count($dims)],
        'weight' => number_format(2.5 + ($i % 10) * 0.4, 1).' kg',
        'year' => 2018 + ($i % 8),
        'medium' => $mediums[($i - 1) % count($mediums)],
        'description' => $description,
        'images' => [$path],
        'thumbnail' => $path,
    ];
}

$export = "<?php\n\nreturn ".var_export($rows, true).";\n";
$target = dirname(__DIR__).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'artworks.php';
file_put_contents($target, $export);
echo "Wrote ".count($rows)." artworks to {$target}\n";
