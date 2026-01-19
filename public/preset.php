<?php
// PRESET PAGINA - Template voor nieuwe projecten
// Geïnspireerd op Bill's Burger Joint stijl
// Haalt data uit Google Sheets

// Convert Google Sheets URL to CSV export URL
$sheetId = '1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k';
$csvUrl = "https://docs.google.com/spreadsheets/d/{$sheetId}/export?format=csv&gid=0";

// Fetch the CSV data
$csvData = file_get_contents($csvUrl);

// Get current domain name (or use query parameter for testing)
// Default to orderli-go.nl for preset page
$currentDomain = isset($_GET['domain']) ? $_GET['domain'] : 'orderli-go.nl';
$domainToMatch = str_replace(':8000', '', $currentDomain);

// Default logo URL (Orderli logo)
$defaultLogoUrl = 'https://i.ibb.co/wN1YhqLD/Orderli-logo-oranje-1.png';

// Parse CSV data
$found = false;
$matchedRow = null;

if ($csvData !== false) {
    $handle = fopen('php://memory', 'r+');
    fwrite($handle, $csvData);
    rewind($handle);
    
    $isFirstRow = true;
    while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
        if ($isFirstRow) {
            $isFirstRow = false;
            continue;
        }
        
        // Check if column A contains the current domain name
        if (isset($row[0]) && (strpos($row[0], $currentDomain) !== false || strpos($row[0], $domainToMatch) !== false)) {
            if (isset($row[1])) {
                $found = true;
                $matchedRow = $row;
                break;
            }
        }
    }
    fclose($handle);
}

// Extract data from sheet or use defaults
// Column mapping: A=domain, B=restaurant_name, C=page_title, D=orderli_link, E=hero_description,
// F=about_text_1, G=about_text_2, H=location_text, I=opening_hours, J=why_us_text,
// K=logo_url, L=bezorging_tijd, M=gratis_bezorging

$restaurantName = $found && isset($matchedRow[1]) && !empty($matchedRow[1]) ? htmlspecialchars($matchedRow[1]) : 'Orderli GO';
$pageTitle = $found && isset($matchedRow[2]) && !empty($matchedRow[2]) ? htmlspecialchars($matchedRow[2]) : 'Welkom bij Orderli GO!';
$orderliLink = $found && isset($matchedRow[3]) && !empty($matchedRow[3]) ? htmlspecialchars($matchedRow[3]) : 'https://orderli.home/orderli-go';
$heroDescription = $found && isset($matchedRow[4]) && !empty($matchedRow[4]) ? htmlspecialchars($matchedRow[4]) : 'Bestel nu en krijg je favoriete gerechten snel thuisbezorgd. Vers bereid en heerlijk vers!';
$aboutText1 = $found && isset($matchedRow[5]) && !empty($matchedRow[5]) ? htmlspecialchars($matchedRow[5]) : 'Welkom bij ons restaurant! Wij serveren al jarenlang heerlijke, verse gerechten met passie en toewijding.';
$aboutText2 = $found && isset($matchedRow[6]) && !empty($matchedRow[6]) ? htmlspecialchars($matchedRow[6]) : 'Bestel nu via Orderli Home en geniet van onze gerechten in het comfort van je eigen huis!';
$locationText = $found && isset($matchedRow[7]) && !empty($matchedRow[7]) ? htmlspecialchars($matchedRow[7]) : 'Bezoek ons op onze locatie of laat je bestelling bezorgen.';
$openingHours = $found && isset($matchedRow[8]) && !empty($matchedRow[8]) ? htmlspecialchars($matchedRow[8]) : "Maandag: 11:00 - 22:00\nDinsdag: 11:00 - 22:00\nWoensdag: 11:00 - 22:00\nDonderdag: 11:00 - 22:00\nVrijdag: 11:00 - 23:00\nZaterdag: 11:00 - 23:00\nZondag: 12:00 - 21:00";
$whyUsText = $found && isset($matchedRow[9]) && !empty($matchedRow[9]) ? htmlspecialchars($matchedRow[9]) : 'Vers bereid, snelle bezorging en altijd met een glimlach.';
$logoUrl = $found && isset($matchedRow[10]) && !empty(trim($matchedRow[10])) ? htmlspecialchars(trim($matchedRow[10])) : $defaultLogoUrl;
$bezorgingTijd = $found && isset($matchedRow[11]) && !empty($matchedRow[11]) ? htmlspecialchars($matchedRow[11]) : '30-45 min';
$gratisBezorging = $found && isset($matchedRow[12]) && !empty($matchedRow[12]) ? htmlspecialchars($matchedRow[12]) : '€15';

// Default values for contact info (not in sheet yet)
$address = 'Voorbeeldstraat 123, 1000 AA Amsterdam';
$phone = '020 123 4567';
$email = 'info@voorbeeld-restaurant.nl';
$instagram = 'https://instagram.com/voorbeeldrestaurant';
$facebook = 'https://facebook.com/voorbeeldrestaurant';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($restaurantName); ?> - <?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            overflow-x: hidden;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            background: transparent;
            backdrop-filter: blur(0px);
            border-bottom: 1px solid transparent;
            transition: all 0.3s ease;
        }
        
        nav.scrolled {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background-color: #0a0a0a;
            overflow: hidden;
        }
        
        .hero-bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.15) 0%, rgba(26, 26, 26, 0) 100%);
            z-index: 1;
        }
        
        .hero-content {
            text-align: center;
            z-index: 2;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 1200px;
            margin: 0;
            padding: 2rem;
            min-height: 100vh;
        }
        
        .hero-img-placeholder {
            width: 300px;
            max-width: 80%;
            margin: 0 auto 3rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-img-placeholder img {
            max-width: 100%;
            height: auto;
        }
        
        @media (min-width: 768px) {
            .hero-img-placeholder {
                width: 400px;
            }
        }
        
        @media (min-width: 1024px) {
            .hero-img-placeholder {
                width: 500px;
            }
        }
        
        .hero-cta-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }
        
        @media (min-width: 768px) {
            .hero-cta-buttons {
                flex-direction: row;
                gap: 1.5rem;
            }
        }
        
        .hero-title {
            font-size: clamp(3rem, 8vw, 8rem);
            font-weight: 900;
            letter-spacing: -0.02em;
            line-height: 0.9;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #cccccc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.5rem);
            font-weight: 300;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 3rem;
        }
        
        .section-label {
            font-size: 0.875rem;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 1rem;
        }
        
        .section-title {
            font-size: clamp(2.5rem, 5vw, 5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.1;
            margin-bottom: 2rem;
        }
        
        /* Button Styles */
        .btn-primary {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: #ffffff;
            color: #0a0a0a;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.875rem;
            border: 2px solid #ffffff;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-primary:hover {
            background: transparent;
            color: #ffffff;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: transparent;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.875rem;
            border: 2px solid #ffffff;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-secondary:hover {
            background: #ffffff;
            color: #0a0a0a;
            transform: translateY(-2px);
        }
        
        /* Section Styles */
        .section {
            padding: 8rem 0;
            position: relative;
        }
        
        .section-dark {            background: #0a0a0a;
            background-image: url(https://billsburger.nl/wp-content/uploads/2022/12/Halftone_20.png);
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
            background-size: 70vw;
        }
        
        .section-light {
            background: #111111;
        }
        
        /* Text Content */
        .text-content {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.125rem;
            line-height: 1.8;
            color: #cccccc;
        }
        
        /* Grid Layouts */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 4rem;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }
        
        /* Contact Info */
        .contact-item {
            margin-bottom: 2rem;
        }
        
        .contact-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #888;
            margin-bottom: 0.5rem;
        }
        
        .contact-value {
            font-size: 1.125rem;
            color: #ffffff;
        }
        
        /* Social Links */
        .social-links {
            display: flex;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            text-decoration: none;
            color: #ffffff;
        }
        
        .social-link:hover {
            border-color: #ffffff;
            transform: translateY(-2px);
        }
        
        /* Instagram Grid */
        .instagram-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 3rem;
        }
        
        .instagram-item {
            aspect-ratio: 1;
            background: #1a1a1a;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .instagram-item:hover {
            border-color: #ffffff;
            transform: scale(1.05);
        }
        
        /* Opening Hours */
        .hours-list {
            list-style: none;
        }
        
        .hours-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .hours-item:last-child {
            border-bottom: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .section {
                padding: 4rem 0;
            }
            
            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
        
        /* Animations */
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
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="mainNav">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold">
                    Orderli <span class="text-orange-500" style="background: black; padding: 2px 5px; border-radius: 5px;">GO</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" class="text-white hover:opacity-70 transition-opacity">facebook</a>
                    <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" class="text-white hover:opacity-70 transition-opacity">instagram</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <img src="https://images.unsplash.com/photo-1652862730768-106cd3cd9ee1?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Hero Background" class="hero-bg-image">
        <div class="hero-content">
            <!-- Hero Logo -->
            <div class="hero-img-placeholder">
                <img src="<?php echo htmlspecialchars($logoUrl); ?>" alt="<?php echo htmlspecialchars($restaurantName); ?> Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            
            <!-- CTA Buttons -->
            <div class="hero-cta-buttons">
                <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="btn-primary" style="min-width: 200px; text-align: center;">
                    Bestel Nu
                </a>
                <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="btn-secondary" style="min-width: 200px; text-align: center;">
                    Bekijk Menu
                </a>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="section section-dark" id="about">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="section-label fade-in-up delay-1">ABOUT US</div>
                <h2 class="section-title fade-in-up delay-2">Over Ons</h2>
                <div class="text-content fade-in-up delay-3">
                    <p class="mb-6"><?php echo nl2br(htmlspecialchars($aboutText1)); ?></p>
                    <?php if (!empty($aboutText2)): ?>
                    <p><?php echo nl2br(htmlspecialchars($aboutText2)); ?></p>
                    <?php endif; ?>
                </div>
                <div class="mt-8 fade-in-up delay-4">
                    <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="btn-secondary">READ MORE</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="section section-light" id="menu">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="section-label fade-in-up delay-1">DISCOVER OUR</div>
                <h2 class="section-title fade-in-up delay-2">MENU</h2>
                <p class="text-content fade-in-up delay-3 mb-8">
                    Ontdek onze heerlijke gerechten. Van klassiekers tot specialiteiten - alles vers bereid met de beste ingrediënten.
                </p>
                <div class="fade-in-up delay-4">
                    <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="btn-primary">DISCOVER MENU</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Section -->
    <section class="section section-dark" id="instagram">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="section-label fade-in-up delay-1">FOLLOW US</div>
                <h2 class="section-title fade-in-up delay-2">Volg Ons</h2>
                <p class="text-content fade-in-up delay-3">
                    Volg ons op Instagram voor de laatste updates, speciale aanbiedingen en een kijkje achter de schermen.
                </p>
                <div class="social-links justify-center fade-in-up delay-4">
                    <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" class="social-link">📷</a>
                    <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" class="social-link">f</a>
                </div>
                <div class="instagram-grid fade-in-up delay-4">
                    <!-- Instagram placeholder items -->
                    <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="instagram-item">
                        <span class="text-4xl opacity-30">🍔</span>
                    </div>
                    <?php endfor; ?>
                </div>
                <div class="mt-6 fade-in-up delay-4">
                    <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" class="text-sm uppercase tracking-wider text-white hover:underline">
                        Volg op Instagram →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section section-light" id="contact">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">
                <div class="section-label text-center fade-in-up delay-1">CONTACT</div>
                <div class="grid-2 mt-12">
                    <div class="fade-in-up delay-2">
                        <div class="contact-item">
                            <div class="contact-label">Adres</div>
                            <div class="contact-value"><?php echo htmlspecialchars($address); ?></div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">Telefoon</div>
                            <div class="contact-value">
                                <a href="tel:<?php echo htmlspecialchars($phone); ?>" class="hover:underline">
                                    <?php echo htmlspecialchars($phone); ?>
                                </a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-label">Email</div>
                            <div class="contact-value">
                                <a href="mailto:<?php echo htmlspecialchars($email); ?>" class="hover:underline">
                                    <?php echo htmlspecialchars($email); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="fade-in-up delay-3">
                        <div class="contact-label mb-4">OPENING HOURS</div>
                        <ul class="hours-list">
                            <?php
                            $hours = explode("\n", $openingHours);
                            foreach ($hours as $hour):
                                if (!empty(trim($hour))):
                                    $parts = explode(':', $hour, 2);
                                    $day = trim($parts[0] ?? '');
                                    $time = trim($parts[1] ?? '');
                            ?>
                            <li class="hours-item">
                                <span><?php echo htmlspecialchars($day); ?>:</span>
                                <span><?php echo htmlspecialchars($time); ?></span>
                            </li>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </ul>
                        <div class="social-links mt-6">
                            <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" class="social-link">facebook</a>
                            <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" class="social-link">instagram</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black py-8 border-t border-white border-opacity-10">
        <div class="container mx-auto px-6 text-center">
            <p class="text-sm text-gray-500">
                &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($restaurantName); ?>. Alle rechten voorbehouden.
            </p>
        </div>
    </footer>

    <script>
        // Navbar scroll behavior - show navbar when scrolled past hero section
        const nav = document.getElementById('mainNav');
        const heroSection = document.querySelector('.hero-section');
        
        function handleNavbarScroll() {
            const heroBottom = heroSection.offsetTop + heroSection.offsetHeight;
            const scrollPosition = window.scrollY + window.innerHeight;
            
            // Check if we've scrolled past the hero section
            if (window.scrollY > heroSection.offsetHeight - 100) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }
        
        // Run on scroll
        window.addEventListener('scroll', handleNavbarScroll);
        // Run on load to check initial position
        handleNavbarScroll();
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Fade in on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
