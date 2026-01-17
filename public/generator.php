<?php
// Generator pagina - simuleert de Custom GPT prompt
// Haalt restaurant data uit Google Sheets en genereert Webflow-concept content

// Convert Google Sheets URL to CSV export URL
$sheetId = '1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k';
$csvUrl = "https://docs.google.com/spreadsheets/d/{$sheetId}/export?format=csv&gid=0";

// Fetch the CSV data
$csvData = file_get_contents($csvUrl);

if ($csvData === false) {
    die("Failed to fetch CSV data");
}

// Get current domain name
$currentDomain = $_SERVER['HTTP_HOST'];
$domainToMatch = str_replace(':8000', '', $currentDomain);

// Parse CSV data
$handle = fopen('php://memory', 'r+');
fwrite($handle, $csvData);
rewind($handle);

$found = false;
$matchedRow = null;
$isFirstRow = true;

while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
    if ($isFirstRow) {
        $isFirstRow = false;
        continue;
    }
    
    if (isset($row[0]) && (strpos($row[0], $currentDomain) !== false || strpos($row[0], $domainToMatch) !== false)) {
        if (isset($row[1])) {
            $found = true;
            $matchedRow = $row;
            break;
        }
    }
}

fclose($handle);

// Extract restaurant data
$restaurantName = isset($matchedRow[1]) && !empty($matchedRow[1]) ? htmlspecialchars($matchedRow[1]) : 'Restaurant';
$restaurantTitle = isset($matchedRow[2]) ? htmlspecialchars($matchedRow[2]) : 'Welkom bij ons restaurant!';
$heroDescription = isset($matchedRow[4]) && !empty($matchedRow[4]) ? htmlspecialchars($matchedRow[4]) : 'Ontdek onze heerlijke gerechten';
$aboutText1 = isset($matchedRow[5]) && !empty($matchedRow[5]) ? htmlspecialchars($matchedRow[5]) : '';
$aboutText2 = isset($matchedRow[6]) && !empty($matchedRow[6]) ? htmlspecialchars($matchedRow[6]) : '';

// Combine about texts for description
$restaurantDescription = trim($aboutText1 . ' ' . $aboutText2);
if (empty($restaurantDescription)) {
    $restaurantDescription = 'Een restaurant met passie voor lekker eten en uitstekende service.';
}

// Webflow section types collection (examples)
$webflowSections = [
    '1.15' => 'Hero met grote achtergrondafbeelding en CTA',
    '4.3' => 'Features grid met iconen',
    '7.2' => 'Testimonials sectie',
    '6.3' => 'Over ons met afbeelding en tekst',
    '2.5' => 'Menu preview grid',
    '5.1' => 'Call to action banner',
    '3.4' => 'Galerij met foto\'s',
    '8.2' => 'Contact formulier sectie'
];

// Generate Webflow concept content
function generateWebflowConcept($restaurantName, $restaurantDescription, $restaurantTitle, $heroDescription) {
    $concept = [];
    
    // Section 1: Hero (1.15)
    $concept[] = [
        'sectie' => '1.15',
        'type' => 'Hero',
        'titel' => $restaurantTitle,
        'tekst' => $heroDescription,
        'knop_tekst' => 'Bekijk Menu',
        'knop_link' => '#menu',
        'afbeelding' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1920&q=80',
        'opmerkingen' => 'Grote hero sectie met restaurant sfeer foto'
    ];
    
    // Section 2: Over Ons (6.3)
    $concept[] = [
        'sectie' => '6.3',
        'type' => 'Over Ons',
        'titel' => 'Over ' . $restaurantName,
        'tekst' => $restaurantDescription,
        'knop_tekst' => 'Lees Meer',
        'knop_link' => '#over-ons',
        'afbeelding' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&q=80',
        'opmerkingen' => 'Tekst links, afbeelding rechts'
    ];
    
    // Section 3: Features (4.3)
    $concept[] = [
        'sectie' => '4.3',
        'type' => 'Features',
        'titel' => 'Waarom kiezen voor ' . $restaurantName . '?',
        'tekst' => 'Ontdek wat ons uniek maakt',
        'knop_tekst' => '',
        'knop_link' => '',
        'afbeelding' => '',
        'opmerkingen' => 'Grid met 3-4 feature cards: Vers bereid, Snelle bezorging, Lokale ingrediënten, Uitstekende service'
    ];
    
    // Section 4: Menu Preview (2.5)
    $concept[] = [
        'sectie' => '2.5',
        'type' => 'Menu Preview',
        'titel' => 'Onze Specialiteiten',
        'tekst' => 'Ontdek onze populairste gerechten',
        'knop_tekst' => 'Bekijk Volledige Menu',
        'knop_link' => '#menu',
        'afbeelding' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1200&q=80',
        'opmerkingen' => 'Grid met 6 menu items met foto\'s'
    ];
    
    // Section 5: Testimonials (7.2)
    $concept[] = [
        'sectie' => '7.2',
        'type' => 'Testimonials',
        'titel' => 'Wat zeggen onze klanten',
        'tekst' => 'Echte reviews van tevreden gasten',
        'knop_tekst' => '',
        'knop_link' => '',
        'afbeelding' => '',
        'opmerkingen' => '3-4 testimonial cards met sterren en quotes'
    ];
    
    // Section 6: CTA (5.1)
    $concept[] = [
        'sectie' => '5.1',
        'type' => 'Call to Action',
        'titel' => 'Klaar om te bestellen?',
        'tekst' => 'Bestel nu en krijg je favoriete gerechten snel thuisbezorgd',
        'knop_tekst' => 'Bestel Nu',
        'knop_link' => '#bestellen',
        'afbeelding' => '',
        'opmerkingen' => 'Prominente CTA banner met gradient achtergrond'
    ];
    
    // Section 7: Galerij (3.4)
    $concept[] = [
        'sectie' => '3.4',
        'type' => 'Galerij',
        'titel' => 'Sfeerimpressies',
        'tekst' => 'Bekijk de sfeer van ons restaurant',
        'knop_tekst' => '',
        'knop_link' => '',
        'afbeelding' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1200&q=80',
        'opmerkingen' => 'Masonry grid met 6-8 restaurant/food foto\'s'
    ];
    
    // Section 8: Contact (8.2)
    $concept[] = [
        'sectie' => '8.2',
        'type' => 'Contact',
        'titel' => 'Neem contact op',
        'tekst' => 'Heb je vragen? We staan voor je klaar!',
        'knop_tekst' => 'Stuur Bericht',
        'knop_link' => '#contact',
        'afbeelding' => '',
        'opmerkingen' => 'Contact formulier met naam, email, bericht velden'
    ];
    
    return $concept;
}

// Generate the concept
$webflowConcept = generateWebflowConcept($restaurantName, $restaurantDescription, $restaurantTitle, $heroDescription);

// Save to JSON file for localhost:8001
$outputFile = __DIR__ . '/../data/generated_concept.json';
file_put_contents($outputFile, json_encode([
    'restaurant_name' => $restaurantName,
    'restaurant_title' => $restaurantTitle,
    'restaurant_description' => $restaurantDescription,
    'hero_description' => $heroDescription,
    'concept' => $webflowConcept,
    'generated_at' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webflow Concept Generator - <?php echo $restaurantName; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-5 py-10 max-w-7xl">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 animate-fadeIn">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Webflow Concept Generator</h1>
            <p class="text-gray-600">Restaurant: <span class="font-semibold"><?php echo $restaurantName; ?></span></p>
            <p class="text-sm text-gray-500 mt-2">Gegenereerd op: <?php echo date('d-m-Y H:i:s'); ?></p>
        </div>

        <!-- Success Message -->
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 animate-fadeIn">
            <p class="font-semibold">✓ Concept succesvol gegenereerd!</p>
            <p class="text-sm mt-1">Het Webflow-concept is opgeslagen en klaar om te bekijken.</p>
        </div>

        <!-- Concept Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8 animate-fadeIn">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6">
                <h2 class="text-2xl font-bold">Webflow Homepage Opzet</h2>
                <p class="text-blue-100 mt-1">Complete sectie-opzet voor <?php echo $restaurantName; ?></p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Sectie</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Type</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Titel</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Tekst</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Knop Tekst</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Knop Link</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Afbeelding URL</th>
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700">Opmerkingen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($webflowConcept as $index => $section): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border border-gray-300 px-4 py-3 font-mono text-blue-600 font-semibold"><?php echo htmlspecialchars($section['sectie']); ?></td>
                            <td class="border border-gray-300 px-4 py-3 text-gray-700"><?php echo htmlspecialchars($section['type']); ?></td>
                            <td class="border border-gray-300 px-4 py-3 text-gray-800 font-medium"><?php echo htmlspecialchars($section['titel']); ?></td>
                            <td class="border border-gray-300 px-4 py-3 text-gray-600 text-sm"><?php echo htmlspecialchars($section['tekst']); ?></td>
                            <td class="border border-gray-300 px-4 py-3 text-gray-700"><?php echo htmlspecialchars($section['knop_tekst']); ?></td>
                            <td class="border border-gray-300 px-4 py-3 text-gray-600 text-sm font-mono"><?php echo htmlspecialchars($section['knop_link']); ?></td>
                            <td class="border border-gray-300 px-4 py-3 text-gray-600 text-xs">
                                <?php if (!empty($section['afbeelding'])): ?>
                                    <a href="<?php echo htmlspecialchars($section['afbeelding']); ?>" target="_blank" class="text-blue-600 hover:underline">Bekijk</a>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-gray-500 text-xs"><?php echo htmlspecialchars($section['opmerkingen']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Button -->
        <div class="text-center animate-fadeIn">
            <a href="http://localhost:8001/viewer.php" target="_blank" class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-lg">
                🚀 Bekijk Concept op Localhost:8001
            </a>
            <p class="text-gray-500 text-sm mt-3">Klik om de gegenereerde content te bekijken</p>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8 animate-fadeIn">
            <h3 class="font-semibold text-blue-900 mb-2">ℹ️ Over dit concept</h3>
            <ul class="text-blue-800 text-sm space-y-1 list-disc list-inside">
                <li>Dit concept is gegenereerd op basis van de Custom GPT prompt voor Webflow restaurant websites</li>
                <li>Alle secties zijn gekozen uit de Webflow sectiecollectie (1.15, 4.3, 7.2, etc.)</li>
                <li>Afbeeldingen zijn Unsplash links voor restaurant- en foodfotografie</li>
                <li>De tabel is klaar om te kopiëren naar 'Template to Complete' in Webflow</li>
                <li>Content is aangepast aan het restaurant: <strong><?php echo $restaurantName; ?></strong></li>
            </ul>
        </div>
    </div>
</body>
</html>

