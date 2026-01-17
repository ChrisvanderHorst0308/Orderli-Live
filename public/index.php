<?php
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
// Also try without port for localhost
$domainToMatch = str_replace(':8000', '', $currentDomain);

// Parse CSV data using a string stream
// Expected Google Sheets structure:
// Row 1: Headers (will be skipped)
// Row 2 (A2) onwards: Data rows
// Column A: Domain name (used for matching)
// Column B: Restaurant name (optional)
// Column C: Page title/headline
// Column D: Orderli Home link URL
// Column E: Hero description text
// Column F: About us text part 1
// Column G: About us text part 2
// Column H: Location text
// Column I: Opening hours (can be formatted text or leave empty for default)
// Column J: Why us text
// Column K: Logo URL (optional, uses placeholder if empty)
// Column L: Bezorging tijd (e.g. "30-45 min")
// Column M: Gratis bezorging vanaf (e.g. "€15")

$handle = fopen('php://memory', 'r+');
fwrite($handle, $csvData);
rewind($handle);

$found = false;
$matchedRow = null;
$isFirstRow = true; // Skip first row (header row)

while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
    // Skip the first row (header row) - start from row 2 (A2)
    if ($isFirstRow) {
        $isFirstRow = false;
        continue;
    }
    
    // Check if column A contains the current domain name (with or without port)
    if (isset($row[0]) && (strpos($row[0], $currentDomain) !== false || strpos($row[0], $domainToMatch) !== false)) {
        if (isset($row[1])) {
            $found = true;
            $matchedRow = $row;
            break;
        }
    }
}

fclose($handle);

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $found && isset($matchedRow[2]) ? htmlspecialchars($matchedRow[2]) : 'Bestel Nu'; ?></title>
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
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slideInUp {
            animation: slideInUp 0.5s ease-out forwards;
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
            background: #f8fafc;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        header {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            height: 50px;
            width: auto;
        }
        
        .logo img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }
        
        .header-info {
            display: flex;
            gap: 2rem;
            align-items: center;
            font-size: 0.9rem;
            color: #64748b;
        }
        
        .header-info span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 800;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .order-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .order-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: #fff;
            color: #dc2626;
            padding: 1.25rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        
        .order-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        
        .order-button.secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 2px solid white;
        }
        
        .order-button.secondary:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .order-icon {
            font-size: 1.5rem;
        }
        
        /* Benefits Bar */
        .benefits {
            background: #fff;
            padding: 1.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            text-align: center;
        }
        
        .benefit-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        
        .benefit-icon {
            font-size: 2rem;
        }
        
        .benefit-text {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
        }
        
        /* Restaurant Info Section */
        .restaurant-section {
            padding: 80px 0;
        }
        
        .restaurant-section h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #1e293b;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .info-card {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.15);
        }
        
        .info-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .info-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #1e293b;
        }
        
        .info-card p {
            color: #64748b;
            line-height: 1.8;
        }
        
        .info-card ul {
            list-style: none;
            padding: 0;
            color: #64748b;
        }
        
        .info-card ul li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-card ul li:last-child {
            border-bottom: none;
        }
        
        .info-card ul li strong {
            color: #1e293b;
            display: inline-block;
            min-width: 120px;
        }
        
        .about-text {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .about-text p {
            color: #64748b;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }
        
        .about-text p:last-child {
            margin-bottom: 0;
        }
        
        /* Sticky CTA */
        .sticky-cta {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
            padding: 1rem 0;
            z-index: 1000;
            display: none;
        }
        
        .sticky-cta.show {
            display: block;
        }
        
        .sticky-cta-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .sticky-cta-text {
            font-weight: 600;
            color: #1e293b;
        }
        
        .sticky-cta-button {
            background: #dc2626;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            transition: background 0.3s;
        }
        
        .sticky-cta-button:hover {
            background: #991b1b;
        }
        
        /* Footer */
        footer {
            background: #1e293b;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .order-buttons {
                flex-direction: column;
            }
            
            .order-button {
                width: 100%;
                justify-content: center;
            }
            
            .header-info {
                display: none;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .sticky-cta-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .sticky-cta-button {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <?php if ($found && isset($matchedRow[2])) { 
        // Map columns from Google Sheets to variables
        // Column A (0): Domain (used for matching)
        // Column B (1): Restaurant name or additional info
        // Column C (2): Page title/headline
        // Column D (3): Orderli Home link
        // Column E (4): Hero description
        // Column F (5): About us text part 1
        // Column G (6): About us text part 2
        // Column H (7): Location text
        // Column I (8): Opening hours (or formatted text)
        // Column J (9): Why us text
        // Column K (10): Logo URL (optional)
        // Column L (11): Bezorging tijd
        // Column M (12): Gratis bezorging vanaf
        
        $pageTitle = isset($matchedRow[2]) ? htmlspecialchars($matchedRow[2]) : 'Bestel Nu';
        $orderliLink = isset($matchedRow[3]) && !empty($matchedRow[3]) ? htmlspecialchars($matchedRow[3]) : '#';
        $heroDescription = isset($matchedRow[4]) && !empty($matchedRow[4]) ? htmlspecialchars($matchedRow[4]) : 'Bestel nu en krijg je favoriete gerechten snel thuisbezorgd. Vers bereid en heerlijk vers!';
        $aboutText1 = isset($matchedRow[5]) && !empty($matchedRow[5]) ? htmlspecialchars($matchedRow[5]) : 'Welkom bij ons restaurant! Wij serveren al jarenlang heerlijke, verse gerechten met passie en toewijding. Onze chef-koks gebruiken alleen de beste ingrediënten om elke maaltijd tot een culinaire ervaring te maken.';
        $aboutText2 = isset($matchedRow[6]) && !empty($matchedRow[6]) ? htmlspecialchars($matchedRow[6]) : 'Of je nu kiest voor een snelle lunch, een uitgebreid diner of een late night snack - wij zorgen ervoor dat elke hap een feestje is. Bestel nu via Orderli Home en geniet van onze gerechten in het comfort van je eigen huis!';
        $locationText = isset($matchedRow[7]) && !empty($matchedRow[7]) ? htmlspecialchars($matchedRow[7]) : 'Bezoek ons op onze locatie of laat je bestelling bezorgen. Wij bezorgen in de hele stad en omgeving.';
        $openingHours = isset($matchedRow[8]) && !empty($matchedRow[8]) ? $matchedRow[8] : null;
        $whyUsText = isset($matchedRow[9]) && !empty($matchedRow[9]) ? htmlspecialchars($matchedRow[9]) : 'Vers bereid, snelle bezorging en altijd met een glimlach. Wij staan bekend om onze kwaliteit en service. Bestel vandaag nog en ervaar het verschil!';
        $logoUrl = isset($matchedRow[10]) && !empty($matchedRow[10]) ? htmlspecialchars($matchedRow[10]) : 'https://via.placeholder.com/150x50/dc2626/ffffff?text=LOGO';
        $bezorgingTijd = isset($matchedRow[11]) && !empty($matchedRow[11]) ? htmlspecialchars($matchedRow[11]) : '30-45 min';
        $gratisBezorging = isset($matchedRow[12]) && !empty($matchedRow[12]) ? htmlspecialchars($matchedRow[12]) : '€15';
    ?>
    
    <header class="bg-white shadow-lg sticky top-0 z-50 animate-fadeIn">
        <nav class="container mx-auto px-5 flex justify-between items-center py-4">
            <div class="logo animate-slideInLeft">
                <img src="<?php echo $logoUrl; ?>" alt="Logo" class="h-12 w-auto">
            </div>
            <div class="header-info hidden md:flex gap-8 items-center text-sm text-gray-600 animate-slideInRight">
                <span class="flex items-center gap-2">🕐 Bezorging <?php echo $bezorgingTijd; ?></span>
                <span class="flex items-center gap-2">📍 Gratis vanaf <?php echo $gratisBezorging; ?></span>
            </div>
        </nav>
    </header>
    
    <section class="hero gradient-animate text-white py-20 text-center">
        <div class="container mx-auto px-5">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 animate-fadeInUp delay-100"><?php echo $pageTitle; ?></h1>
            <p class="text-xl md:text-2xl mb-8 opacity-95 max-w-2xl mx-auto animate-fadeInUp delay-200"><?php echo $heroDescription; ?></p>
            <div class="order-buttons flex justify-center animate-fadeInUp delay-300">
                <a href="<?php echo $orderliLink; ?>" target="_blank" class="order-button bg-white text-red-600 px-8 py-4 rounded-full font-bold text-lg shadow-2xl hover-lift animate-pulse-slow inline-flex items-center gap-3 transition-all duration-300 hover:scale-110">
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
                <p class="text-gray-600 text-lg md:text-xl leading-relaxed mb-6 text-center"><?php echo $aboutText1; ?></p>
                <?php if (!empty($aboutText2)): ?>
                <p class="text-gray-600 text-lg md:text-xl leading-relaxed text-center"><?php echo $aboutText2; ?></p>
                <?php endif; ?>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
                <div class="info-card bg-white p-8 rounded-2xl shadow-lg animate-fadeInUp delay-300 hover-lift transform transition-all duration-300 hover:scale-105">
                    <div class="info-icon text-5xl mb-4 animate-float">📍</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Locatie</h3>
                    <p class="text-gray-600 leading-relaxed"><?php echo $locationText; ?></p>
                </div>
                <div class="info-card bg-white p-8 rounded-2xl shadow-lg animate-fadeInUp delay-400 hover-lift transform transition-all duration-300 hover:scale-105">
                    <div class="info-icon text-5xl mb-4 animate-float delay-200">🕐</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Openingstijden</h3>
                    <?php if ($openingHours): ?>
                        <div class="text-gray-600 leading-relaxed whitespace-pre-line"><?php echo nl2br(htmlspecialchars($openingHours)); ?></div>
                    <?php else: ?>
                        <ul class="list-none space-y-2 text-gray-600">
                            <li class="flex justify-between border-b border-gray-200 pb-2"><strong class="text-gray-800">Maandag:</strong> 11:00 - 22:00</li>
                            <li class="flex justify-between border-b border-gray-200 pb-2"><strong class="text-gray-800">Dinsdag:</strong> 11:00 - 22:00</li>
                            <li class="flex justify-between border-b border-gray-200 pb-2"><strong class="text-gray-800">Woensdag:</strong> 11:00 - 22:00</li>
                            <li class="flex justify-between border-b border-gray-200 pb-2"><strong class="text-gray-800">Donderdag:</strong> 11:00 - 22:00</li>
                            <li class="flex justify-between border-b border-gray-200 pb-2"><strong class="text-gray-800">Vrijdag:</strong> 11:00 - 23:00</li>
                            <li class="flex justify-between border-b border-gray-200 pb-2"><strong class="text-gray-800">Zaterdag:</strong> 11:00 - 23:00</li>
                            <li class="flex justify-between"><strong class="text-gray-800">Zondag:</strong> 12:00 - 21:00</li>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="info-card bg-white p-8 rounded-2xl shadow-lg animate-fadeInUp delay-500 hover-lift transform transition-all duration-300 hover:scale-105">
                    <div class="info-icon text-5xl mb-4 animate-float delay-400">⭐</div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Waarom Ons?</h3>
                    <p class="text-gray-600 leading-relaxed"><?php echo $whyUsText; ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <div class="sticky-cta fixed bottom-0 left-0 right-0 bg-white shadow-2xl py-4 z-50 hidden transition-all duration-300 animate-slideInUp" id="stickyCta">
        <div class="container mx-auto px-5 flex justify-between items-center">
            <div class="sticky-cta-text font-bold text-gray-800 text-lg">Klaar om te bestellen? 🍽️</div>
            <a href="<?php echo $orderliLink; ?>" target="_blank" class="bg-red-600 text-white px-8 py-3 rounded-full font-bold transition-all duration-300 hover:bg-red-700 hover:scale-110 shadow-lg animate-pulse-slow">Bestel Nu</a>
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
        
        // Add scroll animations on load
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                    }
                });
            }, observerOptions);
            
            // Observe all animated elements
            document.querySelectorAll('.animate-fadeInUp, .animate-fadeIn, .animate-slideInLeft, .animate-slideInRight').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
        
    <?php } else { ?>
        <div style="padding: 2rem; text-align: center; font-family: sans-serif;">
            <h1>Domain niet gevonden</h1>
            <p>Row with domain '<?php echo htmlspecialchars($currentDomain); ?>' not found</p>
            <p><small>Zoekt naar: '<?php echo htmlspecialchars($currentDomain); ?>' of '<?php echo htmlspecialchars($domainToMatch); ?>'</small></p>
        </div>
    <?php } ?>
    
</body>
</html>