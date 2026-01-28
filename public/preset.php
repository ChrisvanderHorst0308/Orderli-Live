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
// K=logo_url, L=bezorging_tijd, M=gratis_bezorging, N=menu_description, O=instagram_background_image

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
$menuDescription = $found && isset($matchedRow[13]) && !empty($matchedRow[13]) ? htmlspecialchars($matchedRow[13]) : 'Ontdek onze heerlijke gerechten. Van klassiekers tot specialiteiten, alles vers bereid met de beste ingrediënten.';
$defaultInstagramBg = 'https://images.unsplash.com/photo-1652862730746-93fcd0da61ae?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
$instagramBackgroundImage = $found && isset($matchedRow[14]) && !empty(trim($matchedRow[14])) ? htmlspecialchars(trim($matchedRow[14])) : $defaultInstagramBg;

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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title><?php echo htmlspecialchars($restaurantName); ?> - <?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
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
            z-index: 1000;
            background: transparent;
            backdrop-filter: blur(0px);
            border-bottom: 1px solid transparent;
            transition: all 0.3s ease;
            will-change: transform, opacity, background, backdrop-filter;
        }
        
        nav.scrolled {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Ensure navbar is always visible even during animations */
        nav#mainNav {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        
        /* Hamburger Menu Styles */
        #mobile-menu-toggle {
            z-index: 10;
        }
        
        #mobile-menu-toggle.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        #mobile-menu-toggle.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }
        
        #mobile-menu-toggle.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        #mobile-menu.open {
            max-height: 300px;
        }
        
        nav.scrolled #mobile-menu {
            background: rgba(10, 10, 10, 0.98);
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
            height: 120%;
            object-fit: cover;
            z-index: 0;
            will-change: transform;
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
            background: #f97316;
            color: #ffffff;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.875rem;
            border: 2px solid #ffffff;
            transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            text-decoration: none;
            will-change: transform, background-color;
            backface-visibility: hidden;
            transform: translateZ(0);
        }
        
        .btn-primary:hover {
            background: #ea580c;
            color: #ffffff;
            transform: translateY(-3px) scale(1.02) translateZ(0);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
        }
        
        .btn-primary:active {
            transform: translateY(-1px) scale(0.98) translateZ(0);
            transition: all 0.1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
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
            transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            text-decoration: none;
            will-change: transform, background-color, color;
            backface-visibility: hidden;
            transform: translateZ(0);
        }
        
        .btn-secondary:hover {
            background: #ffffff;
            color: #0a0a0a;
            transform: translateY(-3px) scale(1.02) translateZ(0);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }
        
        .btn-secondary:active {
            transform: translateY(-1px) scale(0.98) translateZ(0);
            transition: all 0.1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        /* Section Styles */
        .section {
            padding: 8rem 0;
            position: relative;
        }
        
        .section-dark {         
            background: #15162A;
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
            background-size: 70vw;
        }
        
        .section-light {
            background: #F4EFE8;
            color: #15162A;
        }
        
        .section-light .section-title,
        .section-light .section-label,
        .section-light .text-content,
        .section-light h1,
        .section-light h2,
        .section-light h3,
        .section-light h4,
        .section-light p,
        .section-light .contact-label,
        .section-light .contact-value {
            color: #15162A;
        }
        
        .section-light .btn-primary {
            background: #15162A;
            color: #ffffff;
            border-color: #15162A;
        }
        
        .section-light .btn-primary:hover {
            background: #0f1120;
            border-color: #0f1120;
            color: #ffffff;
        }
        
        .section-light .btn-secondary {
            background: transparent;
            color: #15162A;
            border-color: #15162A;
        }
        
        .section-light .btn-secondary:hover {
            background: #15162A;
            color: #ffffff;
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
        
        /* Image Collage Styles */
        .image-collage {
            position: relative;
            height: 600px;
        }
        
        .collage-image {
            position: absolute;
            background: #1a1a1a;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 0.875rem;
        }
        
        /* About Section - Prevent Image Overlap */
        #about {
            overflow: hidden;
        }
        
        #about .grid {
            position: relative;
        }
        
        #about .text-left {
            position: relative;
            z-index: 10;
        }
        
        #image-collage-container {
            position: relative;
            z-index: 1;
            overflow: hidden;
            contain: layout;
        }
        
        #parallax-image-1,
        #parallax-image-2,
        #parallax-image-3 {
            contain: layout;
        }
        
        @media (min-width: 1024px) {
            #image-collage-container {
                max-width: 100%;
                overflow: visible;
            }
            
            #parallax-image-1 {
                left: 0;
                max-width: 90%;
            }
            
            #parallax-image-2 {
                right: 0;
                max-width: 90%;
            }
            
            #parallax-image-3 {
                left: 20%;
                max-width: 90%;
            }
        }
        
        @media (max-width: 1024px) {
            .image-collage {
                height: 500px;
                margin-top: 3rem;
            }
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
        
        /* Instagram Section Responsive */
        @media (max-width: 1024px) {
            #instagram .grid {
                grid-template-columns: 1fr;
            }
            
            #instagram .text-left {
                text-align: center;
            }
            
            #instagram .section-title.text-left {
                text-align: center;
            }
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
        
        /* Responsive - Mobile First Approach */
        @media (max-width: 768px) {
            /* Navigation */
            nav {
                padding: 0.75rem 0;
            }
            
            #nav-logo {
                font-size: 1.25rem !important;
            }
            
            #nav-links {
                font-size: 0.7rem;
                gap: 0.5rem !important;
                flex-wrap: wrap;
            }
            
            #nav-links a {
                font-size: 0.7rem !important;
            }
            
            /* Hero Section */
            .hero-section {
                min-height: 100vh;
            }
            
            .hero-content {
                padding: 1rem;
                min-height: 100vh;
            }
            
            .hero-img-placeholder {
                width: 200px !important;
                max-width: 70% !important;
                margin-bottom: 2rem !important;
            }
            
            .hero-cta-buttons {
                flex-direction: column !important;
                gap: 1rem !important;
                width: 100%;
            }
            
            .hero-cta-buttons a {
                width: 100%;
                min-width: auto !important;
                padding: 0.875rem 1.5rem !important;
                font-size: 0.75rem !important;
            }
            
            /* Sections */
            .section {
                padding: 4rem 0 !important;
            }
            
            .section-title {
                font-size: clamp(1.75rem, 6vw, 2.5rem) !important;
                margin-bottom: 1.5rem !important;
            }
            
            .section-label {
                font-size: 0.75rem !important;
            }
            
            .text-content {
                font-size: 1rem !important;
                line-height: 1.6 !important;
            }
            
            /* Buttons */
            .btn-primary,
            .btn-secondary {
                padding: 0.875rem 1.5rem !important;
                font-size: 0.75rem !important;
                width: 100%;
                text-align: center;
            }
            
            .gsap-buttons {
                flex-direction: column !important;
                width: 100%;
            }
            
            .gsap-buttons a {
                width: 100%;
            }
            
            /* Image Collage - Mobile */
            #image-collage-container {
                height: 500px !important;
                margin-top: 2rem;
                margin-bottom: 2rem;
                overflow: hidden !important;
            }
            
            #parallax-image-1,
            #parallax-image-2,
            #parallax-image-3 {
                width: 200px !important;
                height: 200px !important;
                max-width: 45% !important;
            }
            
            #parallax-image-1 {
                top: 0 !important;
                left: 0 !important;
            }
            
            #parallax-image-2 {
                top: 100px !important;
                right: 0 !important;
            }
            
            #parallax-image-3 {
                bottom: 0 !important;
                left: 50% !important;
                transform: translateX(-50%) rotate(3deg) !important;
            }
            
            /* Ensure text doesn't overlap with images */
            #about .grid {
                gap: 3rem !important;
            }
            
            #about .text-left {
                position: relative;
                z-index: 20;
                padding-right: 0 !important;
            }
            
            #image-collage-container {
                position: relative;
                z-index: 1;
            }
            
            /* Grid Layouts */
            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr !important;
                gap: 2rem !important;
            }
            
            /* About Us Section */
            #about .grid {
                grid-template-columns: 1fr !important;
                gap: 3rem !important;
            }
            
            #about .text-left {
                text-align: center !important;
                position: relative;
                z-index: 20;
                padding-bottom: 2rem;
            }
            
            #about .section-title.text-left {
                text-align: center !important;
            }
            
            #about #image-collage-container {
                order: 2;
                margin-top: 0;
            }
            
            #about .text-left {
                order: 1;
            }
            
            /* Instagram Section */
            #instagram .grid {
                grid-template-columns: 1fr !important;
                gap: 2rem !important;
            }
            
            #instagram .text-left {
                text-align: center !important;
            }
            
            #instagram .section-title.text-left {
                text-align: center !important;
            }
            
            /* Logo Box in Instagram Section */
            #instagram .gsap-rotate-in {
                width: 100% !important;
                display: flex;
                justify-content: center;
            }
            
            #instagram .gsap-rotate-in > div {
                width: 250px !important;
                height: 250px !important;
            }
            
            /* Contact Section */
            .contact-item {
                margin-bottom: 1.5rem;
            }
            
            .contact-value {
                font-size: 1rem !important;
            }
            
            /* Container Padding */
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
        
        /* Tablet Responsive */
        @media (min-width: 769px) and (max-width: 1024px) {
            .section {
                padding: 6rem 0;
            }
            
            #image-collage-container {
                height: 650px !important;
            }
            
            #parallax-image-1,
            #parallax-image-2,
            #parallax-image-3 {
                width: 280px !important;
                height: 280px !important;
            }
            
            .hero-img-placeholder {
                width: 250px !important;
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
                <div class="text-2xl font-bold" id="nav-logo">
                    Orderli <span class="text-orange-500" style="background: black; padding: 2px 5px; border-radius: 5px;">GO</span>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-6" id="nav-links">
                    <a href="#about" class="text-white hover:text-orange-500 transition-colors text-sm uppercase tracking-wider">Over ons</a>
                    <a href="#menu" class="text-white hover:text-orange-500 transition-colors text-sm uppercase tracking-wider">Bekijk ons</a>
                    <a href="#instagram" class="text-white hover:text-orange-500 transition-colors text-sm uppercase tracking-wider">Volg ons</a>
                    <a href="#contact" class="text-white hover:text-orange-500 transition-colors text-sm uppercase tracking-wider">Contact</a>
                </div>
                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-toggle" class="md:hidden flex flex-col gap-1.5 p-2 text-white hover:text-orange-500 transition-colors" aria-label="Menu">
                    <span class="hamburger-line w-6 h-0.5 bg-current transition-all duration-300"></span>
                    <span class="hamburger-line w-6 h-0.5 bg-current transition-all duration-300"></span>
                    <span class="hamburger-line w-6 h-0.5 bg-current transition-all duration-300"></span>
                </button>
            </div>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 right-0 bg-[#0a0a0a] border-t border-white border-opacity-10">
                <div class="container mx-auto px-6 py-4 flex flex-col gap-4">
                    <a href="#about" class="text-white hover:text-orange-500 transition-colors text-sm uppercase tracking-wider py-2">Over ons</a>
                    <a href="#menu" class="text-white hover:text-orange-500 transition-colors text-sm uppercase tracking-wider py-2">Bekijk ons</a>
                    <a href="#instagram" class="text-white hover:text-orange-500 transition-colors text-sm uppercase tracking-wider py-2">Volg ons</a>
                    <a href="#contact" class="text-white hover:text-orange-500 transition-colors text-sm uppercase tracking-wider py-2">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <img src="https://images.unsplash.com/photo-1652862730768-106cd3cd9ee1?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Hero Background" class="hero-bg-image" id="hero-bg">
        <div class="hero-content">
            <!-- Hero Logo -->
            <div class="hero-img-placeholder" id="hero-logo">
                <img src="<?php echo htmlspecialchars($logoUrl); ?>" alt="<?php echo htmlspecialchars($restaurantName); ?> Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
            
            <!-- CTA Buttons -->
            <div class="hero-cta-buttons" id="hero-buttons">
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
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                <!-- Left Side: Text Content -->
                <div class="text-left lg:sticky lg:top-24 z-10">
                    <div class="section-label gsap-fade-in text-orange-500 mb-4">OVER ONS</div>
                    <h2 class="section-title gsap-slide-in-left text-left mb-6">Wat is Orderli <span class="text-orange-500">GO</span>?</h2>
                    <div class="text-content gsap-fade-in text-left mb-8">
                        <p class="mb-6"><?php echo nl2br(htmlspecialchars($aboutText1)); ?></p>
                        <?php if (!empty($aboutText2)): ?>
                        <p><?php echo nl2br(htmlspecialchars($aboutText2)); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex gap-4 gsap-buttons" style="opacity: 1; visibility: visible;">
                        <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="btn-primary" style="opacity: 1; visibility: visible;">LEES MEER</a>
                        <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="btn-secondary" style="opacity: 1; visibility: visible;">BESTEL DIRECT</a>
                    </div>
                </div>
                
                <!-- Right Side: Image Collage -->
                <div class="relative h-[850px] md:h-[750px] sm:h-[500px] fade-in-up delay-2 overflow-hidden" id="image-collage-container" style="min-height: 500px;">
                    <!-- Image 1 - Top Left -->
                    <div id="parallax-image-1" class="absolute top-0 left-0 w-96 md:w-80 sm:w-48 h-96 md:h-80 sm:h-48 rounded-lg overflow-hidden shadow-2xl z-10 transform rotate-[-5deg] hover:scale-105 transition-transform duration-300" style="max-width: 100%;">
                        <img src="https://plus.unsplash.com/premium_photo-1667682209368-2e3629cceaa5?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Food Image 1" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Image 2 - Middle Right -->
                    <div id="parallax-image-2" class="absolute top-32 md:top-24 sm:top-20 right-0 w-96 md:w-80 sm:w-48 h-96 md:h-80 sm:h-48 rounded-lg overflow-hidden shadow-2xl z-20 transform rotate-[8deg] hover:scale-105 transition-transform duration-300" style="max-width: 100%;">
                        <img src="https://images.unsplash.com/photo-1642789736327-14d9c36496d7?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OTF8fHBpenphJTIwdGFrZSUyMGF3YXklMjBhd2F5JTIwZm9vZHxlbnwwfHwwfHx8MA%3D%3D" alt="Food Image 2" class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Image 3 - Bottom Left -->
                    <div id="parallax-image-3" class="absolute bottom-0 left-32 md:left-24 sm:left-1/2 sm:-translate-x-1/2 w-96 md:w-80 sm:w-48 h-96 md:h-80 sm:h-48 rounded-lg overflow-hidden shadow-2xl z-30 transform rotate-[3deg] hover:scale-105 transition-transform duration-300" style="max-width: 100%;">
                        <img src="https://plus.unsplash.com/premium_photo-1738431864495-ac46ae40e4f6?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Food Image 3" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="section section-light gsap-section" id="menu">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="section-label gsap-fade-in text-orange-500">BEKIJK ONS</div>
                <h2 class="section-title gsap-scale-in">MENU</h2>
                <p class="text-content gsap-fade-in mb-8">
                    <?php echo $menuDescription; ?>
                </p>
                <div class="gsap-button-bounce">
                    <a href="<?php echo htmlspecialchars($orderliLink); ?>" target="_blank" class="btn-primary">DISCOVER MENU</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Section -->
    <section class="section" id="instagram" style="background-image: url('<?php echo htmlspecialchars($instagramBackgroundImage); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative; padding: 8rem 0;">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
                <!-- Left Side: Dark Blue Block -->
                <div class="bg-[#15162A] rounded-2xl p-8 md:p-12 gsap-slide-in-right" style="background: #15162A;">
                    <div class="text-left">
                        <div class="section-label gsap-fade-in mb-4 text-orange-500">VOLG ONS</div>
                        <h2 class="section-title gsap-fade-in text-left mb-6">Blijf op de hoogte</h2>
                        <p class="text-content gsap-fade-in text-left mb-8">
                            Vergeet niet om ons te volgen op Instagram om op de hoogte te blijven van al het laatste nieuws en promoties bij <?php echo htmlspecialchars($restaurantName); ?>! Onze Instagram pagina staat vol met smakelijke foto's van onze heerlijke gerechten, evenals een kijkje achter de schermen in het dagelijks leven van ons restaurant. We posten ook regelmatig speciale deals en giveaways voor onze volgers, dus zorg ervoor dat je ons volgt!
                        </p>
                        <div class="gsap-buttons flex flex-wrap gap-4" style="opacity: 1; visibility: visible;">
                            <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" class="btn-secondary" style="opacity: 1; visibility: visible;">Volg op Instagram</a>
                            <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" class="btn-secondary" style="opacity: 1; visibility: visible;">Volg op Facebook</a>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side: Logo Box (Los van de div) -->
                <div class="gsap-rotate-in">
                    <div class="flex flex-col items-center justify-center rounded-lg p-6" style="width: 300px; height: 300px; background: #15162A;">
                        <!-- Logo wit -->
                        <div class="mb-6" style="filter: brightness(0) invert(1);">
                            <img src="<?php echo htmlspecialchars($logoUrl); ?>" alt="<?php echo htmlspecialchars($restaurantName); ?> Logo" class="max-w-full max-h-48 object-contain">
                        </div>
                        <!-- Social Media Icons -->
                        <div class="flex gap-4">
                            <a href="<?php echo htmlspecialchars($instagram); ?>" target="_blank" class="text-white hover:text-orange-500 transition-colors">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="<?php echo htmlspecialchars($facebook); ?>" target="_blank" class="text-white hover:text-orange-500 transition-colors">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
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
        
        // Ensure navbar is visible immediately
        if (nav) {
            nav.style.opacity = '1';
            nav.style.transform = 'translateY(0)';
        }
        
        // Mobile Menu Toggle
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuLinks = mobileMenu ? mobileMenu.querySelectorAll('a') : [];
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', () => {
                mobileMenuToggle.classList.toggle('active');
                mobileMenu.classList.toggle('open');
            });
            
            // Close menu when clicking on a link
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenuToggle.classList.remove('active');
                    mobileMenu.classList.remove('open');
                });
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenuToggle.classList.remove('active');
                    mobileMenu.classList.remove('open');
                }
            });
        }
        
        function handleNavbarScroll() {
            if (!nav || !heroSection) return;
            
            const scrollPosition = window.scrollY;
            const heroHeight = heroSection.offsetHeight;
            
            // Check if we've scrolled past the hero section
            // Add background when scrolled past hero section (50px before end for smooth transition)
            if (scrollPosition > heroHeight - 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
            
            // Always ensure navbar is visible
            nav.style.opacity = '1';
            nav.style.transform = 'translateY(0)';
        }
        
        // Run on scroll with throttling
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            if (scrollTimeout) {
                window.cancelAnimationFrame(scrollTimeout);
            }
            scrollTimeout = window.requestAnimationFrame(handleNavbarScroll);
        }, { passive: true });
        
        // Run on load to check initial position
        handleNavbarScroll();
        
        // Ensure navbar is visible after GSAP animations
        setTimeout(() => {
            if (nav) {
                nav.style.opacity = '1';
                nav.style.transform = 'translateY(0)';
            }
        }, 1000);
        
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

        // Register GSAP ScrollTrigger plugin
        gsap.registerPlugin(ScrollTrigger);

        // ============================================
        // REFRESH/ON-LOAD ANIMATIONS
        // ============================================
        
        // Set initial states for refresh animations
        // Navbar should always be visible, so we animate from slightly above
        gsap.set("#mainNav", { y: -20, opacity: 0.8 });
        gsap.set("#hero-bg", { scale: 1.2, opacity: 0 });
        gsap.set("#hero-logo", { scale: 0.5, opacity: 0, rotation: -10 });
        gsap.set("#hero-buttons a", { y: 50, opacity: 0 });
        gsap.set("#nav-logo", { x: -30, opacity: 0.8 });
        gsap.set("#nav-links", { x: 30, opacity: 0.8 });

        // Create master timeline for page load animations
        const pageLoadTL = gsap.timeline();

        // Navbar animation - ensure it's always visible
        pageLoadTL.to("#mainNav", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            ease: "power2.out"
        });

        // Navbar logo and social links
        pageLoadTL.to("#nav-logo", {
            x: 0,
            opacity: 1,
            duration: 0.5,
            ease: "power2.out"
        }, "-=0.3");

        pageLoadTL.to("#nav-links", {
            x: 0,
            opacity: 1,
            duration: 0.5,
            ease: "power2.out"
        }, "-=0.5");

        // Hero background image
        pageLoadTL.to("#hero-bg", {
            scale: 1,
            opacity: 1,
            duration: 1.5,
            ease: "power2.out"
        }, "-=0.5");

        // Hero logo animation
        pageLoadTL.to("#hero-logo", {
            scale: 1,
            opacity: 1,
            rotation: 0,
            duration: 1,
            ease: "elastic.out(1, 0.5)"
        }, "-=0.8");

        // Hero buttons with fast smooth stagger animation
        pageLoadTL.to("#hero-buttons a", {
            y: 0,
            opacity: 1,
            scale: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out"
        }, "-=0.5");

        // ============================================
        // SCROLL ANIMATIONS
        // ============================================

        // Hero Background Parallax Effect - runs after page load
        // Wait for page load timeline to complete
        pageLoadTL.call(() => {
            const heroBg = document.getElementById('hero-bg');
            const heroSection = document.querySelector('.hero-section');
            
            if (heroBg && heroSection) {
                // Parallax effect - only y movement, preserve scale from page load
                gsap.to(heroBg, {
                    y: -150,
                    ease: "none",
                    scrollTrigger: {
                        trigger: heroSection,
                        start: "top top",
                        end: "bottom top",
                        scrub: 1.5,
                        invalidateOnRefresh: true
                    }
                });
            }
        });

        // GSAP Parallax animations for images
        const parallaxImage1 = document.getElementById('parallax-image-1');
        const parallaxImage2 = document.getElementById('parallax-image-2');
        const parallaxImage3 = document.getElementById('parallax-image-3');
        const parallaxContainer = document.getElementById('image-collage-container');

        if (parallaxContainer && parallaxImage1 && parallaxImage2 && parallaxImage3) {
            // Check if mobile device
            const isMobile = window.innerWidth <= 768;
            
            // Set initial states for scroll animations (less movement on mobile)
            const initialY = isMobile ? 20 : 50;
            const initialScale = isMobile ? 0.9 : 0.8;
            const initialRotation1 = isMobile ? -8 : -15;
            const initialRotation2 = isMobile ? 12 : 20;
            const initialRotation3 = isMobile ? -5 : -10;
            
            gsap.set(parallaxImage1, { opacity: 0, scale: initialScale, rotation: initialRotation1, y: initialY });
            gsap.set(parallaxImage2, { opacity: 0, scale: initialScale, rotation: initialRotation2, y: initialY });
            gsap.set(parallaxImage3, { opacity: 0, scale: initialScale, rotation: initialRotation3, y: initialY });

            // Image 1 - Scroll animation (fade in, scale, rotate)
            gsap.to(parallaxImage1, {
                opacity: 1,
                scale: 1,
                rotation: -5,
                y: 0,
                duration: isMobile ? 0.8 : 1.2,
                ease: "elastic.out(1, 0.6)",
                scrollTrigger: {
                    trigger: parallaxContainer,
                    start: "top 85%",
                    end: "top 50%",
                    toggleActions: "play none none reverse"
                }
            });

            // Parallax effects (reduced on mobile for better performance)
            const parallaxSpeed1 = isMobile ? -50 : -100;
            const parallaxSpeed2 = isMobile ? -100 : -200;
            const parallaxSpeed3 = isMobile ? -150 : -300;
            
            // Image 1 - Parallax effect (moves slowly UP)
            gsap.to(parallaxImage1, {
                y: parallaxSpeed1,
                ease: "none",
                scrollTrigger: {
                    trigger: parallaxContainer,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: 1,
                }
            });

            // Image 2 - Scroll animation (fade in, scale, rotate) with delay
            gsap.to(parallaxImage2, {
                opacity: 1,
                scale: 1,
                rotation: 8,
                y: 0,
                duration: isMobile ? 0.8 : 1.2,
                ease: "elastic.out(1, 0.6)",
                delay: 0.2,
                scrollTrigger: {
                    trigger: parallaxContainer,
                    start: "top 85%",
                    end: "top 50%",
                    toggleActions: "play none none reverse"
                }
            });

            // Image 2 - Parallax effect (moves medium-fast UP)
            gsap.to(parallaxImage2, {
                y: parallaxSpeed2,
                ease: "none",
                scrollTrigger: {
                    trigger: parallaxContainer,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: 1,
                }
            });

            // Image 3 - Scroll animation (fade in, scale, rotate) with more delay
            gsap.to(parallaxImage3, {
                opacity: 1,
                scale: 1,
                rotation: 3,
                y: 0,
                duration: isMobile ? 0.8 : 1.2,
                ease: "elastic.out(1, 0.6)",
                delay: 0.4,
                scrollTrigger: {
                    trigger: parallaxContainer,
                    start: "top 85%",
                    end: "top 50%",
                    toggleActions: "play none none reverse"
                }
            });

            // Image 3 - Parallax effect (moves very fast UP)
            gsap.to(parallaxImage3, {
                y: parallaxSpeed3,
                ease: "none",
                scrollTrigger: {
                    trigger: parallaxContainer,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: 1,
                }
            });
        }

        // GSAP Scroll Animations for various elements
        // Fade in animations with improved settings
        gsap.utils.toArray('.gsap-fade-in').forEach((element) => {
            gsap.from(element, {
                opacity: 0,
                y: 50,
                duration: 1.2,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: element,
                    start: "top 85%",
                    end: "top 50%",
                    toggleActions: "play none none reverse",
                    once: false // Allow animation to replay
                }
            });
        });

        // Slide in from left with improved animation (reduced on mobile)
        gsap.utils.toArray('.gsap-slide-in-left').forEach((element) => {
            const isMobile = window.innerWidth <= 768;
            gsap.from(element, {
                x: isMobile ? -50 : -150,
                opacity: 0,
                duration: isMobile ? 0.8 : 1.2,
                ease: "power4.out",
                scrollTrigger: {
                    trigger: element,
                    start: "top 85%",
                    end: "top 50%",
                    toggleActions: "play none none reverse",
                    once: false
                }
            });
        });

        // Slide in from right with improved animation (reduced on mobile)
        gsap.utils.toArray('.gsap-slide-in-right').forEach((element) => {
            const isMobile = window.innerWidth <= 768;
            gsap.from(element, {
                x: isMobile ? 50 : 150,
                opacity: 0,
                duration: isMobile ? 0.8 : 1.2,
                ease: "power4.out",
                scrollTrigger: {
                    trigger: element,
                    start: "top 85%",
                    end: "top 50%",
                    toggleActions: "play none none reverse",
                    once: false
                }
            });
        });

        // Scale in animation with bounce effect
        gsap.utils.toArray('.gsap-scale-in').forEach((element) => {
            gsap.from(element, {
                scale: 0.5,
                opacity: 0,
                duration: 1.2,
                ease: "elastic.out(1, 0.6)",
                scrollTrigger: {
                    trigger: element,
                    start: "top 85%",
                    end: "top 50%",
                    toggleActions: "play none none reverse",
                    once: false
                }
            });
        });

        // Rotate in animation
        gsap.utils.toArray('.gsap-rotate-in').forEach((element) => {
            gsap.from(element, {
                rotation: -10,
                opacity: 0,
                scale: 0.9,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: element,
                    start: "top 85%",
                    toggleActions: "play none none reverse"
                }
            });
        });

        // Button animations with stagger
        gsap.utils.toArray('.gsap-buttons').forEach((container) => {
            const buttons = container.querySelectorAll('a, button');
            
            // Ensure buttons are visible initially
            buttons.forEach(btn => {
                btn.style.opacity = '1';
                btn.style.visibility = 'visible';
            });
            
            // Animate from slightly below, but keep visible
            gsap.from(buttons, {
                y: 20,
                opacity: 0.8,
                duration: 0.8,
                stagger: 0.2,
                ease: "power2.out",
                scrollTrigger: {
                    trigger: container,
                    start: "top 85%",
                    toggleActions: "play none none reverse"
                }
            });
        });

        // Button bounce animation
        gsap.utils.toArray('.gsap-button-bounce').forEach((element) => {
            gsap.from(element, {
                y: 50,
                opacity: 0,
                scale: 0.8,
                duration: 1,
                ease: "elastic.out(1, 0.5)",
                scrollTrigger: {
                    trigger: element,
                    start: "top 85%",
                    toggleActions: "play none none reverse"
                }
            });
        });

        // Section animations with improved settings
        gsap.utils.toArray('.gsap-section').forEach((section) => {
            gsap.from(section, {
                opacity: 0,
                y: 80,
                duration: 1.5,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: section,
                    start: "top 80%",
                    end: "top 40%",
                    toggleActions: "play none none reverse",
                    once: false
                }
            });
        });

        // ============================================
        // ENHANCED SCROLL EFFECTS
        // ============================================
        
        // Additional scroll-based animations can be added here
    </script>
</body>
</html>
