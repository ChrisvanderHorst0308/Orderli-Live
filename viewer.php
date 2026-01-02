<?php
// Viewer pagina - toont de gegenereerde Webflow concept content
// Draait op localhost:8001

$conceptFile = 'generated_concept.json';

if (!file_exists($conceptFile)) {
    die('Geen concept gevonden. Genereer eerst een concept op localhost:8000/generator.php');
}

$conceptData = json_decode(file_get_contents($conceptFile), true);

if (!$conceptData) {
    die('Fout bij het laden van het concept.');
}

$restaurantName = $conceptData['restaurant_name'] ?? 'Restaurant';
$restaurantTitle = $conceptData['restaurant_title'] ?? 'Welkom!';
$restaurantDescription = $conceptData['restaurant_description'] ?? '';
$heroDescription = $conceptData['hero_description'] ?? '';
$concept = $conceptData['concept'] ?? [];
$generatedAt = $conceptData['generated_at'] ?? '';

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webflow Concept Viewer - <?php echo $restaurantName; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .section-card {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .section-card:nth-child(1) { animation-delay: 0.1s; opacity: 0; }
        .section-card:nth-child(2) { animation-delay: 0.2s; opacity: 0; }
        .section-card:nth-child(3) { animation-delay: 0.3s; opacity: 0; }
        .section-card:nth-child(4) { animation-delay: 0.4s; opacity: 0; }
        .section-card:nth-child(5) { animation-delay: 0.5s; opacity: 0; }
        .section-card:nth-child(6) { animation-delay: 0.6s; opacity: 0; }
        .section-card:nth-child(7) { animation-delay: 0.7s; opacity: 0; }
        .section-card:nth-child(8) { animation-delay: 0.8s; opacity: 0; }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg">
        <div class="container mx-auto px-5 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold"><?php echo htmlspecialchars($restaurantName); ?></h1>
                    <p class="text-blue-100 mt-1">Webflow Concept Preview</p>
                </div>
                <a href="http://localhost:8000/generator.php" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                    ← Terug naar Generator
                </a>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-5 py-10 max-w-7xl">
        <!-- Hero Section -->
        <?php if (!empty($concept[0])): $hero = $concept[0]; ?>
        <section class="section-card mb-12">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="relative h-96 bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($hero['afbeelding']); ?>')">
                    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                    <div class="relative h-full flex items-center justify-center text-center text-white px-5">
                        <div>
                            <h2 class="text-5xl md:text-6xl font-bold mb-4"><?php echo htmlspecialchars($hero['titel']); ?></h2>
                            <p class="text-xl md:text-2xl mb-6 max-w-2xl mx-auto"><?php echo htmlspecialchars($hero['tekst']); ?></p>
                            <?php if (!empty($hero['knop_tekst'])): ?>
                            <a href="<?php echo htmlspecialchars($hero['knop_link']); ?>" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-full font-bold text-lg hover:bg-blue-50 transition-colors">
                                <?php echo htmlspecialchars($hero['knop_tekst']); ?>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t">
                    <p class="text-xs text-gray-500">Sectie <?php echo htmlspecialchars($hero['sectie']); ?> - <?php echo htmlspecialchars($hero['type']); ?></p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Over Ons Section -->
        <?php if (!empty($concept[1])): $about = $concept[1]; ?>
        <section class="section-card mb-12">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/2 p-8 md:p-12 flex items-center">
                        <div>
                            <h2 class="text-4xl font-bold text-gray-800 mb-4"><?php echo htmlspecialchars($about['titel']); ?></h2>
                            <p class="text-gray-600 text-lg leading-relaxed"><?php echo nl2br(htmlspecialchars($about['tekst'])); ?></p>
                            <?php if (!empty($about['knop_tekst'])): ?>
                            <a href="<?php echo htmlspecialchars($about['knop_link']); ?>" class="inline-block mt-6 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                <?php echo htmlspecialchars($about['knop_tekst']); ?>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <img src="<?php echo htmlspecialchars($about['afbeelding']); ?>" alt="<?php echo htmlspecialchars($about['titel']); ?>" class="w-full h-full object-cover min-h-96">
                    </div>
                </div>
                <div class="p-4 bg-gray-50 border-t">
                    <p class="text-xs text-gray-500">Sectie <?php echo htmlspecialchars($about['sectie']); ?> - <?php echo htmlspecialchars($about['type']); ?></p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Features Section -->
        <?php if (!empty($concept[2])): $features = $concept[2]; ?>
        <section class="section-card mb-12">
            <div class="bg-white rounded-lg shadow-xl p-8 md:p-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center"><?php echo htmlspecialchars($features['titel']); ?></h2>
                <p class="text-gray-600 text-center mb-8"><?php echo htmlspecialchars($features['tekst']); ?></p>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="text-4xl mb-3">⚡</div>
                        <h3 class="font-bold text-gray-800 mb-2">Vers Bereid</h3>
                        <p class="text-sm text-gray-600">Dagverse ingrediënten</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="text-4xl mb-3">🚀</div>
                        <h3 class="font-bold text-gray-800 mb-2">Snelle Bezorging</h3>
                        <p class="text-sm text-gray-600">Binnen 30-45 minuten</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="text-4xl mb-3">🌱</div>
                        <h3 class="font-bold text-gray-800 mb-2">Lokale Ingrediënten</h3>
                        <p class="text-sm text-gray-600">Van lokale leveranciers</p>
                    </div>
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="text-4xl mb-3">⭐</div>
                        <h3 class="font-bold text-gray-800 mb-2">Uitstekende Service</h3>
                        <p class="text-sm text-gray-600">Altijd met een glimlach</p>
                    </div>
                </div>
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Sectie <?php echo htmlspecialchars($features['sectie']); ?> - <?php echo htmlspecialchars($features['type']); ?>: <?php echo htmlspecialchars($features['opmerkingen']); ?></p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Menu Preview Section -->
        <?php if (!empty($concept[3])): $menu = $concept[3]; ?>
        <section class="section-card mb-12">
            <div class="bg-white rounded-lg shadow-xl p-8 md:p-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center"><?php echo htmlspecialchars($menu['titel']); ?></h2>
                <p class="text-gray-600 text-center mb-8"><?php echo htmlspecialchars($menu['tekst']); ?></p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 bg-gray-200"></div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-2">Menu Item <?php echo $i + 1; ?></h3>
                            <p class="text-sm text-gray-600 mb-2">Heerlijk gerecht met verse ingrediënten</p>
                            <p class="text-lg font-bold text-blue-600">€12,50</p>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
                <?php if (!empty($menu['knop_tekst'])): ?>
                <div class="text-center">
                    <a href="<?php echo htmlspecialchars($menu['knop_link']); ?>" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        <?php echo htmlspecialchars($menu['knop_tekst']); ?>
                    </a>
                </div>
                <?php endif; ?>
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Sectie <?php echo htmlspecialchars($menu['sectie']); ?> - <?php echo htmlspecialchars($menu['type']); ?></p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Testimonials Section -->
        <?php if (!empty($concept[4])): $testimonials = $concept[4]; ?>
        <section class="section-card mb-12">
            <div class="bg-white rounded-lg shadow-xl p-8 md:p-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center"><?php echo htmlspecialchars($testimonials['titel']); ?></h2>
                <p class="text-gray-600 text-center mb-8"><?php echo htmlspecialchars($testimonials['tekst']); ?></p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php 
                    $testimonialQuotes = [
                        'Fantastisch eten en snelle bezorging! Echt een aanrader.',
                        'De beste pizza die ik ooit heb gehad. Vers en heerlijk!',
                        'Uitstekende service en kwaliteit. We komen zeker terug!'
                    ];
                    for ($i = 0; $i < 3; $i++): 
                    ?>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="flex mb-3">
                            <?php for ($j = 0; $j < 5; $j++): ?>
                            <span class="text-yellow-400 text-xl">⭐</span>
                            <?php endfor; ?>
                        </div>
                        <p class="text-gray-700 mb-4 italic">"<?php echo $testimonialQuotes[$i]; ?>"</p>
                        <p class="text-sm font-semibold text-gray-800">- Tevreden Klant</p>
                    </div>
                    <?php endfor; ?>
                </div>
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Sectie <?php echo htmlspecialchars($testimonials['sectie']); ?> - <?php echo htmlspecialchars($testimonials['type']); ?></p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- CTA Section -->
        <?php if (!empty($concept[5])): $cta = $concept[5]; ?>
        <section class="section-card mb-12">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-xl p-12 text-center text-white">
                <h2 class="text-4xl font-bold mb-4"><?php echo htmlspecialchars($cta['titel']); ?></h2>
                <p class="text-xl mb-8 text-blue-100"><?php echo htmlspecialchars($cta['tekst']); ?></p>
                <?php if (!empty($cta['knop_tekst'])): ?>
                <a href="<?php echo htmlspecialchars($cta['knop_link']); ?>" class="inline-block bg-white text-blue-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-blue-50 transition-colors">
                    <?php echo htmlspecialchars($cta['knop_tekst']); ?>
                </a>
                <?php endif; ?>
                <div class="mt-6 p-4 bg-white bg-opacity-20 rounded-lg">
                    <p class="text-xs text-blue-100">Sectie <?php echo htmlspecialchars($cta['sectie']); ?> - <?php echo htmlspecialchars($cta['type']); ?></p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Footer Info -->
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <p class="text-gray-600">Concept gegenereerd op: <span class="font-semibold"><?php echo htmlspecialchars($generatedAt); ?></span></p>
            <p class="text-sm text-gray-500 mt-2">Dit is een preview van het Webflow concept voor <?php echo htmlspecialchars($restaurantName); ?></p>
        </div>
    </div>
</body>
</html>

