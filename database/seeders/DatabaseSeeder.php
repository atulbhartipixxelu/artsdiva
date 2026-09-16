<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\HeroSlide;
use App\Models\NewsPost;
use App\Models\Page;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@artsdiva.com',
            'password' => Hash::make(env('SEED_SUPERADMIN_PASSWORD', 'ChangeMe-SuperAdmin-'.date('Y'))),
            'role' => 'superadmin',
            'is_active' => true,
        ]);
        User::create([
            'name' => 'Content Admin',
            'email' => 'admin@artsdiva.com',
            'password' => Hash::make(env('SEED_ADMIN_PASSWORD', 'ChangeMe-Admin-'.date('Y'))),
            'role' => 'admin',
            'is_active' => true,
        ]);

        Page::query()->delete();
        Page::insert([
            [
                'slug' => 'about',
                'title' => 'About',
                'subtitle' => 'ArtsDiva is a fine art acquisition and annual leasing platform for a curated clientele.',
                'body' => "Our approach\n\nWe place exceptional works with collectors and spaces that value craft, narrative, and longevity — whether through outright acquisition or a flexible annual lease.\n\nWhat we offer\n\nA transparent catalogue with multi-currency pricing, estimated lease rates, and a dedicated enquiry flow.",
                'cta_label' => 'Browse Catalogue',
                'cta_url' => 'catalogue',
                'meta_description' => 'About ArtsDiva fine art acquisition and leasing.',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'leasing',
                'title' => 'Leasing',
                'subtitle' => 'Fine art acquisition and annual leasing for residences, workplaces, and collections.',
                'body' => "Acquisition\n\nWe source and place works matched to scale, palette, and narrative — with transparent pricing in your preferred currency.\n\nAnnual leasing\n\nLease rates start at 10% per annum for works valued under €25,000 EUR, scaling down for higher-value pieces. Request a lease from any artwork page or via the enquiry form.",
                'cta_label' => 'Start a Lease Inquiry',
                'cta_url' => 'leasing-inquiry',
                'meta_description' => 'ArtsDiva annual leasing and acquisition services.',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'contact',
                'title' => 'Contact',
                'subtitle' => 'Reach the ArtsDiva client team.',
                'body' => "Client desk\n\nEmail: hello@artsdiva.com\nPhone: +1 (000) 000-0000\n\nFor leasing, use the dedicated enquiry form so we can capture artwork, duration, and budget in one place.",
                'cta_label' => 'Enquire',
                'cta_url' => 'leasing-inquiry',
                'meta_description' => 'Contact ArtsDiva.',
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        HeroSlide::query()->delete();
        $heroes = [
            ['Curated Masterpieces', 'A Journey Through Timeless Expression', 'images/hero-banner-01.png'],
            ['Living With Art', 'Acquisition and annual leasing for refined spaces', 'images/hero-banner-02.png'],
        ];
        foreach ($heroes as $i => [$title, $sub, $img]) {
            HeroSlide::create([
                'eyebrow' => 'Featured Collection — Contemporary Art — Worldwide',
                'title' => $title,
                'subtitle' => $sub,
                'image' => $img,
                'button_one_label' => 'Browse Catalogue',
                'button_one_url' => 'catalogue',
                'button_two_label' => 'Enquire About Leasing',
                'button_two_url' => 'leasing-inquiry',
                'is_published' => true,
                'sort_order' => $i,
            ]);
        }

        Artist::query()->delete();
        Artwork::query()->delete();
        $artists = [
            [
                'Frida Kahlo', 'Mexico City', 'Mexico', 'images/catalogue/artwork-040.png',
                'Frida Kahlo (1907–1954) is among the most recognised figures in twentieth-century Mexican art. Her self-portraits stage personal and political identity through symbolism, Indigenous dress, and an unflinching frontal gaze. Works such as The Two Fridas and Self-Portrait with Monkey remain central references for collectors of modern Latin American painting.',
            ],
            [
                'M.F. Husain', 'Mumbai', 'India', 'images/catalogue/artwork-036.png',
                'M.F. Husain (1915–2011) was a founding member of the Progressive Artists\' Group and one of modern Indian art\'s most influential painters. Across six decades, his semi-abstract figurative language — especially the galloping horse — fused folk memory, myth, and bold colour into an instantly recognisable visual vocabulary.',
            ],
            [
                'Keith Haring', 'New York', 'USA', 'images/catalogue/artwork-002.png',
                'Keith Haring (1958–1990) brought subway drawings and public murals into the centre of contemporary art. His radiant figures, barking dogs, and UFO motifs — rendered in bold contour and flat colour — remain a defining bridge between street culture and Pop Art.',
            ],
            [
                'Camille Pissarro', 'Paris', 'France', 'images/catalogue/artwork-080.png',
                'Camille Pissarro (1830–1903) was a senior figure among the Impressionists, respected by Cézanne and Gauguin. He painted rural paths, village life, and Paris boulevards with structured colour and steady attention to everyday subjects.',
            ],
            [
                'Alfred Sisley', 'Paris', 'France', 'images/catalogue/artwork-081.png',
                'Alfred Sisley (1839–1899) devoted his career almost entirely to landscape. Open sky, shifting light, and high horizons distinguish his Impressionist views of fields and villages from more narrative approaches within the circle.',
            ],
            [
                'Aisha Rahman', 'Mumbai', 'India', 'images/catalogue/artwork-004.png',
                'Aisha Rahman draws from the energy of street culture and graphic line work. Her practice blends bold silhouettes, playful figures, and documentary portraiture into collecting-ready works for contemporary spaces.',
            ],
            [
                'Luca Moretti', 'Milan', 'Italy', 'images/catalogue/artwork-005.png',
                'Luca Moretti creates vivid pop-inflected compositions filled with rhythmic characters and saturated colour. His prints and canvases bring gallery-grade impact to residential and hospitality interiors.',
            ],
            [
                'Priya Kapoor', 'Delhi', 'India', 'images/catalogue/artwork-006.png',
                'Priya Kapoor is known for large-scale figurative murals and wall-ready editions that celebrate movement, community, and colour. Her work translates public-art energy into collectible fine pieces.',
            ],
            [
                'Noah Bennett', 'New York', 'USA', 'images/catalogue/artwork-007.png',
                'Noah Bennett explores weathered crimson surfaces and vertical drip textures. His abstract panels are designed as strong focal points for modern lofts, studios, and boutique hotels.',
            ],
            [
                'Hana Suzuki', 'Tokyo', 'Japan', 'images/catalogue/artwork-008.png',
                'Hana Suzuki presents intimate, highly textured red abstracts within refined gallery framing. Her pieces favour quiet luxury — small scale, deep pigment, and architectural placement.',
            ],
            [
                'Omar Farid', 'Dubai', 'UAE', 'images/catalogue/artwork-009.png',
                'Omar Farid works between object and image, photographing sculptural forms and reflective circular vessels. His editions feel meditative, tactile, and suited to minimalist collections.',
            ],
            [
                'Clara Weiss', 'Berlin', 'Germany', 'images/catalogue/artwork-010.png',
                'Clara Weiss builds spare geometric compositions around metallic discs and dark grounds. Her black-and-white studies emphasise material contrast and calm precision.',
            ],
            [
                'Rohan Mehta', 'Jaipur', 'India', 'images/catalogue/artwork-011.png',
                'Rohan Mehta pairs celestial moon studies with warm interior colour stories. His framed works are curated for living rooms that need quiet atmosphere and soft light.',
            ],
            [
                'Isla Quinn', 'London', 'UK', 'images/catalogue/artwork-012.png',
                'Isla Quinn paints panoramic mineral horizons in layered ochres and burgundies. Her horizontal formats are ideal above seating and console vignettes in residential collections.',
            ],
            [
                'Diego Alvarez', 'Barcelona', 'Spain', 'images/catalogue/artwork-013.png',
                'Diego Alvarez blends Eastern seal marks with fluid pigment landscapes. Earthy reds, golds, and cream washes define his warm, design-led abstract series.',
            ],
            [
                'Mei Zhou', 'Shanghai', 'China', 'images/catalogue/artwork-014.png',
                'Mei Zhou is recognised for saturated magenta panels and bedroom-scale diptychs. Colour intensity and clean framing make her work a favourite for boutique residential projects.',
            ],
            [
                'Samir Patel', 'Singapore', 'Singapore', 'images/catalogue/artwork-015.png',
                'Samir Patel creates monumental crimson diptychs for dramatic interiors. Layered red textures and generous scale define his acquisition-focused practice.',
            ],
            [
                'Freya Olsen', 'Paris', 'France', 'images/catalogue/artwork-016.png',
                'Freya Olsen investigates gravity and pigment through vertical drip abstractions. Her red canvases feel both raw and elegant — suited to collectors who favour process-driven work.',
            ],
            [
                'Kenji Sato', 'Kyoto', 'Japan', 'images/catalogue/artwork-017.png',
                'Kenji Sato documents night streets, silhouettes, and urban rhythm. His photographic editions capture bikes, lights, and late-hour movement with cinematic contrast.',
            ],
            [
                'Amara Nwosu', 'Lagos', 'Nigeria', 'images/catalogue/artwork-018.png',
                'Amara Nwosu builds and strips pigment layers to reveal cracked, timeworn crimson fields. Her monochrome abstracts speak to erosion, memory, and emotional colour.',
            ],
            [
                'Leo Hartmann', 'Vienna', 'Austria', 'images/catalogue/artwork-019.png',
                'Leo Hartmann photographs intimate black-and-white encounters — often animals and quiet domestic thresholds. His prints balance humour, tenderness, and graphic negative space.',
            ],
            [
                'Yara Haddad', 'Beirut', 'Lebanon', 'images/catalogue/artwork-020.png',
                'Yara Haddad turns night markets and crowded pavements into luminous street narratives. High-contrast blacks and flares of light define her documentary series.',
            ],
        ];
        $artistModels = [];
        foreach ($artists as $i => [$name, $city, $country, $img, $bio]) {
            $artistModels[] = Artist::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'city' => $city,
                'country' => $country,
                'image' => $img,
                'bio' => $bio,
                'is_featured' => $i < 8,
                'is_published' => true,
                'sort_order' => $i,
            ]);
        }

        $artworksConfig = require database_path('../config/artworks.php');
        $artistByName = [];
        foreach ($artistModels as $model) {
            $artistByName[$model->name] = $model;
        }

        // Latest client-curated works appear first in catalogue (Recommended).
        $prioritySlugs = [
            'the-two-fridas',
            'self-portrait-with-monkey',
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

        foreach ($artworksConfig as $i => $row) {
            $artist = $artistByName[$row['artist']] ?? $artistModels[$i % count($artistModels)];
            $priority = array_search($row['slug'], $prioritySlugs, true);
            $sortOrder = $priority === false ? (1000 + $i) : $priority;

            Artwork::create([
                'artist_id' => $artist->id,
                'title' => $row['title'],
                'slug' => $row['slug'],
                'city' => $row['city'],
                'category' => $row['category'],
                'price_eur' => $row['price_eur'],
                'dimensions' => $row['dimensions'],
                'weight' => $row['weight'],
                'year' => $row['year'],
                'medium' => $row['medium'],
                'description' => $row['description'],
                'thumbnail' => $row['thumbnail'],
                'gallery' => $row['images'],
                'is_featured' => $priority !== false,
                'is_published' => true,
                'sort_order' => $sortOrder,
            ]);
        }

        Exhibition::query()->delete();
        $exhibits = [
            ['Abstract Horizons', 'Contemporary Abstract Painting', '15 September – 20 December 2026', 'New Delhi, India', 'images/catalogue/artwork-002.png'],
            ['Echoes of Light', 'Oil on Canvas Collection', '01 October – 15 January 2027', 'Milan, Italy', 'images/catalogue/artwork-003.png'],
            ['Urban Expressions', 'Contemporary Mixed Media', '20 September – 10 December 2026', 'New York, USA', 'images/catalogue/artwork-004.png'],
            ['Nature in Motion', 'Landscape Fine Art Collection', '05 October – 18 January 2027', 'Paris, France', 'images/catalogue/artwork-005.png'],
            ['Silent Forms', 'Minimal Sculpture Series', '12 November – 28 February 2027', 'London, UK', 'images/catalogue/artwork-006.png'],
            ['Chromatic Fields', 'Colour Field Paintings', '08 December – 30 March 2027', 'Tokyo, Japan', 'images/catalogue/artwork-007.png'],
            ['Figurative Light', 'Portrait & Figurative Works', '18 January – 22 April 2027', 'Berlin, Germany', 'images/catalogue/artwork-008.png'],
            ['Material Memory', 'Mixed Media Assemblage', '02 February – 15 May 2027', 'Dubai, UAE', 'images/catalogue/artwork-009.png'],
        ];
        foreach ($exhibits as $i => [$title, $sub, $dates, $loc, $img]) {
            Exhibition::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'subtitle' => $sub,
                'dates' => $dates,
                'location' => $loc,
                'image' => $img,
                'is_published' => true,
                'sort_order' => $i,
            ]);
        }

        Event::query()->delete();
        $events = [
            ['Exclusive Art Acquisition Evening', ['Tours'], '10 October 2026', '7:00 PM – 9:30 PM', 'Singapore', 'images/catalogue/artwork-010.png'],
            ['Contemporary Collecting Workshop', ['Learning', 'Workshops'], '18 October 2026', '4:00 PM – 6:00 PM', 'Mumbai, India', 'images/catalogue/artwork-011.png'],
            ['Author Meet & Catalogue Signing', ['Book Signings'], '25 October 2026', '6:30 PM – 8:00 PM', 'London, UK', 'images/catalogue/artwork-012.png'],
            ['Materials & Mediums Masterclass', ['Learning', 'Workshops'], '02 November 2026', '3:00 PM – 5:30 PM', 'New York, USA', 'images/catalogue/artwork-013.png'],
            ['Private Gallery Walkthrough', ['Tours'], '08 November 2026', '5:00 PM – 7:00 PM', 'Paris, France', 'images/catalogue/artwork-014.png'],
            ['Leasing for Interiors Seminar', ['Learning'], '15 November 2026', '6:00 PM – 8:00 PM', 'Dubai, UAE', 'images/catalogue/artwork-015.png'],
            ['Artist Conversation Series', ['Tours', 'Learning'], '22 November 2026', '7:00 PM – 9:00 PM', 'Berlin, Germany', 'images/catalogue/artwork-016.png'],
            ['Year-End Collectors Reception', ['Tours'], '05 December 2026', '7:30 PM – 10:00 PM', 'Tokyo, Japan', 'images/catalogue/artwork-017.png'],
        ];
        foreach ($events as $i => [$title, $tags, $date, $time, $loc, $img]) {
            Event::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'tags' => $tags,
                'date_label' => $date,
                'time_label' => $time,
                'location' => $loc,
                'image' => $img,
                'description' => 'Join ArtsDiva for '.$title.'.',
                'is_published' => true,
                'sort_order' => $i,
            ]);
        }

        NewsPost::query()->delete();
        $news = [
            [
                'Tree Canopy Studies Enter the Collection',
                'New black-and-white canopy photographs bring quiet outdoor light into residential placements.',
                "ArtsDiva has added a focused series of looking-up tree studies to the catalogue — dense silhouettes, filtered daylight, and calm architectural pairing.\n\nCollectors looking for restorative interiors can lease or acquire these editions for bedrooms, reading rooms, and wellness spaces.",
                'images/catalogue/artwork-031.png',
            ],
            [
                'Interior Placement: Art Above the Bed',
                'How framed silhouettes and soft abstracts are shaping bedroom acquisition lists this season.',
                "From mustard accent pillows to herringbone floors, our latest client placements show how quiet photographic works transform restful rooms.\n\nBrowse the catalogue for bedroom-scale pieces ready for annual leasing or outright acquisition.",
                'images/catalogue/artwork-023.png',
            ],
            [
                'Colour Forward: Crimson Abstracts Rising',
                'Saturated red textures continue to lead contemporary collecting conversations.',
                "Deep crimson panels and weathered pigment fields remain high on advisor shortlists for modern lofts and boutique hotels.\n\nArtsDiva’s leasing desk can estimate annual rates from catalogue values, with transparent tiers for works under and above €25,000.",
                'images/catalogue/artwork-015.png',
            ],
            [
                'Night Streets: New Documentary Editions',
                'Urban night photography captures bikes, stalls, and late-hour city light.',
                "A new documentary cluster joins the platform — high-contrast street scenes that suit hospitality corridors, creative offices, and collectors drawn to cinematic atmosphere.\n\nRequest a lease enquiry from any artwork page to discuss placement and duration.",
                'images/catalogue/artwork-017.png',
            ],
            [
                'Studio Notes: Husain Equine Motifs',
                'Horse (1960) and Galloping Horses highlight the motif that defined M.F. Husain\'s career.',
                "Husain's horses are among the most recognized motifs in Indian modern art. From a solitary figure on a red ground to multi-horse fields in flat colour and bold outline, the image stood for energy and movement.\n\nExplore Horse (1960), Galloping Horses, and Nude Figure with Cityscape in the ArtsDiva catalogue.",
                'images/catalogue/artwork-036.png',
            ],
            [
                'Portrait Classics: Frida Kahlo',
                'The Two Fridas and Self-Portrait with Monkey enter the curated catalogue with full artwork notes.',
                "Frida Kahlo's double self-portrait The Two Fridas (1939) and Self-Portrait with Monkey remain landmarks of twentieth-century Mexican art.\n\nRead the full notes on each artwork page, or browse Frida Kahlo under Artists.",
                'images/catalogue/artwork-041.png',
            ],
            [
                'Living With Warm Horizons',
                'Earthy panoramic abstracts bring mineral colour into lounge placements.',
                "Soft burgundy, ochre, and cream horizons are leading residential mood boards. Wide formats sit naturally above sofas and console vignettes.\n\nAnnual leasing remains available for clients who want rotation without full capital commitment.",
                'images/catalogue/artwork-010.png',
            ],
            [
                'Shadow Geometry in Architecture',
                'Barred windows and cast light become minimal fine-art photographs.',
                "High-contrast architectural studies continue to appeal to design-led collectors. Diagonal shadows, textured plaster, and quiet geometry define the series.\n\nView the full set online or enquire for a private walkthrough.",
                'images/catalogue/artwork-020.png',
            ],
        ];
        foreach ($news as $i => [$title, $excerpt, $body, $img]) {
            NewsPost::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => $excerpt,
                'body' => $body,
                'image' => $img,
                'published_at' => now()->subDays($i * 3),
                'is_published' => true,
            ]);
        }

        Publication::query()->delete();
        $pubs = [
            [
                'Frida Kahlo',
                'The Two Fridas',
                'images/catalogue/artwork-041.png',
                'Painted following her divorce from Diego Rivera, this double self-portrait presents two versions of the artist seated side by side, hearts exposed and connected by a single vein.',
                "Painted following her divorce from Diego Rivera, this double self-portrait presents two versions of the artist seated side by side, hearts exposed and connected by a single vein. One Frida wears European dress, the other Tehuana costume, reflecting her dual heritage and the emotional rupture of the period. It stands among the most studied works of twentieth-century Mexican art.\n\nThe painting was exhibited at the International Surrealist Exhibition in Mexico City in 1940 and today hangs in the Museo de Arte Moderno, Mexico City.",
            ],
            [
                'Frida Kahlo',
                'Self-Portrait with Monkey',
                'images/catalogue/artwork-040.png',
                'Kahlo frequently placed herself among animals and dense foliage, using them as both companions and symbolic guardians.',
                "Kahlo frequently placed herself among animals and dense foliage, using them as both companions and symbolic guardians. The spider monkey at her shoulder and the red ribbon at her throat recur across several of her self-portraits from this period, each carrying personal and political undertones tied to her identity and physical suffering.",
            ],
            [
                'M.F. Husain',
                'Horse (1960)',
                'images/catalogue/artwork-036.png',
                'Husain\'s horses are among the most recognized motifs in Indian modern art, rendered here against a field of red.',
                "Husain's horses are among the most recognized motifs in Indian modern art, rendered here in fractured white and black against a field of red. The horse recurs throughout his body of work as a symbol of energy and movement, drawing on both classical Indian sculpture and modernist abstraction.",
            ],
            [
                'M.F. Husain',
                'Galloping Horses',
                'images/catalogue/artwork-048.png',
                'Several horses in motion, each in a distinct flat colour and outlined in bold black line.',
                "This composition brings together several horses in motion, each rendered in a distinct flat color and outlined in bold black line. Husain's treatment owes as much to Indian miniature painting as to European modernism, compressing multiple animals into a single dynamic field.",
            ],
            [
                'M.F. Husain',
                'Nude Figure with Cityscape',
                'images/catalogue/artwork-035.png',
                'A red female figure mapped onto India\'s cities and symbols — Delhi, Benaras, Kolkata.',
                "Husain places a red female figure at the center of this work, her outstretched limbs connecting a wheel motif to place names including Delhi, Benaras, and Kolkata. The painting reflects his recurring interest in mapping the female form onto the geography and symbolism of India.",
            ],
            [
                'Keith Haring',
                'Untitled (UFO and Dogs)',
                'images/catalogue/artwork-002.png',
                'Dotted dog figures and a UFO beam in Haring\'s signature contour and flat colour.',
                "Bold black outlines, flat colour, and kinetic energy lines define this work. Two of Haring's iconic dotted dog figures encounter a blue UFO casting a pink beam — a recurring motif from his early 1980s vocabulary that bridges street culture and Pop Art.",
            ],
            [
                'Camille Pissarro',
                'Boulevard Montmartre',
                'images/catalogue/artwork-083.png',
                'Parisian boulevard life painted from an upper-floor window in soft winter light, 1897.',
                "Painted from an upper-floor window, this view captures the bustle of Parisian boulevard life in soft winter light. Pissarro produced a series of works from this vantage point, tracking the same street under changing weather and time of day.",
            ],
            [
                'Alfred Sisley',
                'Fields near a Village',
                'images/catalogue/artwork-081.png',
                'Open sky and cultivated fields — Sisley\'s characteristic high horizon and cloud attention.',
                "Sisley's landscapes favored open sky and shifting light over incident or narrative. This view across cultivated fields toward a distant village shows his characteristic high horizon line and attention to cloud formation, qualities that set him apart within the Impressionist circle.",
            ],
        ];
        foreach ($pubs as $i => $pub) {
            [$artist, $title, $img, $excerpt] = array_slice($pub, 0, 4);
            Publication::create([
                'artist_name' => $artist,
                'title' => $title,
                'slug' => Str::slug($title.'-'.$i),
                'excerpt' => $excerpt,
                'image' => $img,
                'is_published' => true,
                'sort_order' => $i,
            ]);
        }
    }
}
