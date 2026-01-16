<?php
// PRESET PAGINA - Template voor nieuwe projecten
// Dit is de basis template die gebruikt wordt om nieuwe projecten te maken

// Demo data voor de preset (wordt gebruikt als template)
$presetData = [
    'domain' => 'voorbeeld-restaurant.nl',
    'restaurant_name' => 'Voorbeeld Restaurant',
    'page_title' => 'Welkom bij ons restaurant!',
    'orderli_link' => 'https://orderli.home/voorbeeld-restaurant',
    'hero_description' => 'Bestel nu en krijg je favoriete gerechten snel thuisbezorgd. Vers bereid en heerlijk vers!',
    'about_text_1' => 'Welkom bij ons restaurant! Wij serveren al jarenlang heerlijke, verse gerechten met passie en toewijding. Onze chef-koks gebruiken alleen de beste ingrediënten om elke maaltijd tot een culinaire ervaring te maken.',
    'about_text_2' => 'Of je nu kiest voor een snelle lunch, een uitgebreid diner of een late night snack - wij zorgen ervoor dat elke hap een feestje is. Bestel nu via Orderli Home en geniet van onze gerechten in het comfort van je eigen huis!',
    'location_text' => 'Bezoek ons op onze locatie of laat je bestelling bezorgen. Wij bezorgen in de hele stad en omgeving.',
    'opening_hours' => "Maandag: 11:00 - 22:00\nDinsdag: 11:00 - 22:00\nWoensdag: 11:00 - 22:00\nDonderdag: 11:00 - 22:00\nVrijdag: 11:00 - 23:00\nZaterdag: 11:00 - 23:00\nZondag: 12:00 - 21:00",
    'why_us_text' => 'Vers bereid, snelle bezorging en altijd met een glimlach. Wij staan bekend om onze kwaliteit en service. Bestel vandaag nog en ervaar het verschil!',
    'logo_url' => 'https://via.placeholder.com/150x50/dc2626/ffffff?text=LOGO',
    'bezorging_tijd' => '30-45 min',
    'gratis_bezorging' => '€15'
];

// Gebruik de preset data voor de pagina
$pageTitle = $presetData['page_title'];
$orderliLink = $presetData['orderli_link'];
$heroDescription = $presetData['hero_description'];
$aboutText1 = $presetData['about_text_1'];
$aboutText2 = $presetData['about_text_2'];
$locationText = $presetData['location_text'];
$openingHours = $presetData['opening_hours'];
$whyUsText = $presetData['why_us_text'];
$logoUrl = $presetData['logo_url'];
$bezorgingTijd = $presetData['bezorging_tijd'];
$gratisBezorging = $presetData['gratis_bezorging'];

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
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
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .animate-slideInLeft {
            animation: slideInLeft 0.6s ease-out forwards;
        }
        
        .animate-slideInRight {
            animation: slideInRight 0.6s ease-out forwards;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }
        
        .delay-100 {
            animation-delay: 0.1s;
            opacity: 0;
        }
        
        .delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }
        
        .delay-300 {
            animation-delay: 0.3s;
            opacity: 0;
        }
        
        .delay-400 {
            animation-delay: 0.4s;
            opacity: 0;
        }
        
        .delay-500 {
            animation-delay: 0.5s;
            opacity: 0;
        }
        
        .delay-600 {
            animation-delay: 0.6s;
            opacity: 0;
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .gradient-animate {
            background: linear-gradient(-45deg, #dc2626, #991b1b, #dc2626, #ef4444);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-lg sticky top-0 z-50 animate-fadeIn">
        <nav class="container mx-auto px-5 flex justify-between items-center py-4">
            <div class="logo animate-slideInLeft">
                <img src="<?php echo htmlspecialchars($logoUrl); ?>" alt="Logo" class="h-12 w-auto">
            </div>
            <div class="header-info hidden md:flex gap-8 items-center text-sm text-gray-600 animate-slideInRight">
                <span class="flex items-center gap-2">🕐 Bezorging <?php echo htmlspecialchars($bezorgingTijd); ?></span>
                <span class="flex items-center gap-2">📍 Gratis vanaf <?php echo htmlspecialchars($gratisBezorging); ?></span>
            </div>
        </nav>
    </header>
    
    <section class="hero gradient-animate text-white py-20 text-center">
        <div class="container mx-auto px-5">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 animate-fadeInUp delay-100"><?php echo htmlspecialchars($pageTitle); ?></h1>
            <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-2xl mx-auto animate-fadeInUp delay-200"><?php echo htmlspecialchars($heroDescription); ?></p>
            <div class="order-buttons flex justify-center animate-fadeInUp delay-300">
                <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="order-button bg-white text-red-600 px-8 py-4 rounded-full font-bold text-lg shadow-2xl hover-lift animate-pulse-slow inline-flex items-center gap-3 transition-all duration-300 hover:scale-110">
                    <span class="order-icon text-2xl animate-float">🍽️</span>
                    <span>Bestel via Orderli Home</span>
                </a>
            </div>
        </div>
    </section>
    
    <section class="benefits bg-white py-8 border-b border-gray-200">
        <div class="container mx-auto px-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="benefit-item flex flex-col items-center gap-2 animate-fadeInUp delay-100 hover-lift p-4 rounded-lg">
                    <div class="benefit-icon text-4xl animate-bounce">⚡</div>
                    <div class="benefit-text text-sm font-semibold text-gray-600">Snelle Bezorging</div>
                </div>
                <div class="benefit-item flex flex-col items-center gap-2 animate-fadeInUp delay-200 hover-lift p-4 rounded-lg">
                    <div class="benefit-icon text-4xl animate-bounce delay-100">🆓</div>
                    <div class="benefit-text text-sm font-semibold text-gray-600">Gratis Bezorging</div>
                </div>
                <div class="benefit-item flex flex-col items-center gap-2 animate-fadeInUp delay-300 hover-lift p-4 rounded-lg">
                    <div class="benefit-icon text-4xl animate-bounce delay-200">🔥</div>
                    <div class="benefit-text text-sm font-semibold text-gray-600">Vers Bereid</div>
                </div>
                <div class="benefit-item flex flex-col items-center gap-2 animate-fadeInUp delay-400 hover-lift p-4 rounded-lg">
                    <div class="benefit-icon text-4xl animate-bounce delay-300">⭐</div>
                    <div class="benefit-text text-sm font-semibold text-gray-600">4.8/5 Beoordeling</div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="restaurant-section bg-gray-50 py-20">
        <div class="container mx-auto px-5">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 text-gray-800 animate-fadeInUp">Over Ons</h2>
            <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-xl animate-fadeInUp delay-200 hover-lift">
                <p class="text-gray-600 text-lg md:text-xl leading-relaxed mb-6 text-center"><?php echo nl2br(htmlspecialchars($aboutText1)); ?></p>
                <?php if (!empty($aboutText2)): ?>
                <p class="text-gray-600 text-lg md:text-xl leading-relaxed text-center"><?php echo nl2br(htmlspecialchars($aboutText2)); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <div class="info-card bg-white p-8 rounded-2xl shadow-lg animate-fadeInUp delay-300 hover-lift transform transition-all duration-300 hover:scale-105">
                    <div class="info-icon text-5xl mb-4 animate-float">📍</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Locatie</h3>
                    <p class="text-gray-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($locationText)); ?></p>
                </div>
                <div class="info-card bg-white p-8 rounded-2xl shadow-lg animate-fadeInUp delay-400 hover-lift transform transition-all duration-300 hover:scale-105">
                    <div class="info-icon text-5xl mb-4 animate-float delay-200">🕐</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Openingstijden</h3>
                    <div class="text-gray-600 leading-relaxed whitespace-pre-line"><?php echo nl2br(htmlspecialchars($openingHours)); ?></div>
                </div>
                <div class="info-card bg-white p-8 rounded-2xl shadow-lg animate-fadeInUp delay-500 hover-lift transform transition-all duration-300 hover:scale-105">
                    <div class="info-icon text-5xl mb-4 animate-float delay-400">⭐</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Waarom Ons?</h3>
                    <p class="text-gray-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($whyUsText)); ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <div class="sticky-cta fixed bottom-0 left-0 right-0 bg-white shadow-2xl py-4 z-50 hidden transition-all duration-300 animate-slideInUp" id="stickyCta">
        <div class="container mx-auto px-5 flex justify-between items-center">
            <div class="sticky-cta-text font-bold text-gray-800 text-lg">Klaar om te bestellen? 🍽️</div>
            <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="bg-red-600 text-white px-8 py-3 rounded-full font-bold transition-all duration-300 hover:bg-red-700 hover:scale-110 shadow-lg animate-pulse-slow">Bestel Nu</a>
        </div>
    </div>
    
    <footer class="bg-gray-900 text-white py-8 animate-fadeIn">
        <div class="container mx-auto px-5 text-center">
            <p class="text-lg">&copy; <?php echo date('Y'); ?> Bestel Nu. Alle rechten voorbehouden.</p>
            <p class="mt-2 text-sm opacity-80">Bestel nu via Orderli Home</p>
        </div>
    </footer>
    
    <script>
        // Show sticky CTA when user scrolls down
        window.addEventListener('scroll', function() {
            const stickyCta = document.getElementById('stickyCta');
            if (window.scrollY > 300) {
                stickyCta.classList.remove('hidden');
                stickyCta.classList.add('block');
            } else {
                stickyCta.classList.add('hidden');
                stickyCta.classList.remove('block');
            }
        });
    </script>
</body>
</html>
