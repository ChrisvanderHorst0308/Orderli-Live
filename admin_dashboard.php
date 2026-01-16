<?php
session_start();

$USERNAME = 'chris';
$PASSWORD = 'Orderli123';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: /admin_login.php');
    exit;
}

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: /admin_login.php');
    exit;
}

$googleSheetUrl = 'https://docs.google.com/spreadsheets/d/1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k/edit?usp=sharing';
$sheetId = '1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k';

// Google Apps Script Webhook URL
$webhookUrl = 'https://script.google.com/macros/s/AKfycbwcd4_gcHouyoPeToIXD8xWQkQCqeC52GNB_8wjBI4PX_GMKlWdE81HvqVoukvnikSarg/exec';

// Fetch existing projects from Google Sheets
$projects = [];
$csvUrl = "https://docs.google.com/spreadsheets/d/{$sheetId}/export?format=csv&gid=0";
$csvData = @file_get_contents($csvUrl);

if ($csvData !== false) {
    $handle = fopen('php://memory', 'r+');
    fwrite($handle, $csvData);
    rewind($handle);
    
    $isFirstRow = true;
    while (($row = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
        if ($isFirstRow) {
            $isFirstRow = false;
            continue; // Skip header row
        }
        
        // Extract project data (kolom B = restaurant name, kolom A = domain)
        if (isset($row[1]) && !empty(trim($row[1]))) {
            $projects[] = [
                'domain' => $row[0] ?? '',
                'restaurant_name' => $row[1] ?? '',
                'page_title' => $row[2] ?? '',
                'orderli_link' => $row[3] ?? '',
                'row_number' => count($projects) + 2 // +2 because row 1 is header, and we start counting from 0
            ];
        }
    }
    fclose($handle);
}

// Handle new project creation
$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'new_project') {
    $projectData = [
        'domain' => $_POST['domain'] ?? '',
        'restaurant_name' => $_POST['restaurant_name'] ?? '',
        'page_title' => $_POST['page_title'] ?? '',
        'orderli_link' => $_POST['orderli_link'] ?? '',
        'hero_description' => $_POST['hero_description'] ?? '',
        'about_text_1' => $_POST['about_text_1'] ?? '',
        'about_text_2' => $_POST['about_text_2'] ?? '',
        'location_text' => $_POST['location_text'] ?? '',
        'opening_hours' => $_POST['opening_hours'] ?? '',
        'why_us_text' => $_POST['why_us_text'] ?? '',
        'logo_url' => $_POST['logo_url'] ?? '',
        'bezorging_tijd' => $_POST['bezorging_tijd'] ?? '',
        'gratis_bezorging' => $_POST['gratis_bezorging'] ?? '',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    // Prepare row data for Google Sheets (in correct order: A-M)
    $rowData = [
        $projectData['domain'],
        $projectData['restaurant_name'],
        $projectData['page_title'],
        $projectData['orderli_link'],
        $projectData['hero_description'],
        $projectData['about_text_1'],
        $projectData['about_text_2'],
        $projectData['location_text'],
        $projectData['opening_hours'],
        $projectData['why_us_text'],
        $projectData['logo_url'],
        $projectData['bezorging_tijd'],
        $projectData['gratis_bezorging']
    ];
    
    // Save to pending projects JSON (backup)
    $pendingFile = __DIR__ . '/pending_projects.json';
    $pendingProjects = [];
    if (file_exists($pendingFile)) {
        $pendingProjects = json_decode(file_get_contents($pendingFile), true) ?? [];
    }
    $pendingProjects[] = $projectData;
    file_put_contents($pendingFile, json_encode($pendingProjects, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    // Try to send to Google Sheets via webhook if URL is set
    if (!empty($webhookUrl)) {
        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['row' => $rowData]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $message = '✅ Project succesvol toegevoegd aan Google Sheets!';
            $success = true;
        } else {
            $message = '⚠️ Project opgeslagen lokaal. Google Sheets webhook niet beschikbaar. Gebruik de CSV download.';
        }
    } else {
        // Generate CSV for manual import
        $csvOutput = '"' . implode('","', array_map(function($field) {
            return str_replace('"', '""', $field);
        }, $rowData)) . '"' . "\n";
        
        $filename = 'new_project_' . date('Y-m-d_His') . '.csv';
        file_put_contents($filename, $csvOutput);
        
        $_SESSION['download_file'] = $filename;
        $_SESSION['download_data'] = $csvOutput;
        $message = '✅ Project opgeslagen! Download de CSV hieronder en importeer in Google Sheets (of stel webhook in voor automatisch toevoegen).';
    }
}

// Handle CSV download
if (isset($_GET['download']) && isset($_SESSION['download_file'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $_SESSION['download_file'] . '"');
    echo $_SESSION['download_data'];
    unset($_SESSION['download_file']);
    unset($_SESSION['download_data']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Orderli</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-50 min-h-screen">
    <header class="border-b border-slate-800 bg-slate-900/70 backdrop-blur sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center font-bold">A</div>
                <div>
                    <p class="text-xs text-slate-400">Orderli Admin</p>
                    <h1 class="text-xl font-semibold">Dashboard</h1>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm text-slate-400">
                <a href="?action=logout" class="text-red-300 hover:text-red-200">Uitloggen</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-8">
        <!-- Preset Preview Section -->
        <section class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-blue-900/20">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-slate-400">Preset Template</p>
                    <h2 class="text-2xl font-semibold text-slate-50">Converterende Bestelpagina</h2>
                    <p class="text-sm text-slate-400 mt-1">Dit is de basis template voor alle nieuwe projecten</p>
                </div>
                <a href="/preset.php" target="_blank" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 font-semibold transition-colors">
                    🔗 Open Preset
                </a>
            </div>
            
            <!-- Preset Preview iframe -->
            <div class="mt-4 rounded-lg border border-slate-800 overflow-hidden bg-slate-800">
                <div class="relative" style="padding-bottom: 75%; height: 0; overflow: hidden;">
                    <iframe src="/preset.php" 
                            class="absolute top-0 left-0 w-full h-full border-0" 
                            style="transform: scale(0.4); transform-origin: 0 0; width: 250%; height: 2500px; pointer-events: none;"></iframe>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-2">💡 Dit is de preset template. Alle nieuwe projecten gebruiken deze structuur.</p>
        </section>

        <!-- Google Sheet Link -->
        <section class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-blue-900/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-400">Data Bron</p>
                    <h2 class="text-2xl font-semibold text-slate-50">Google Sheets</h2>
                    <p class="text-sm text-slate-400 mt-1">Alle project data wordt opgeslagen in Google Sheets</p>
                </div>
                <a href="<?php echo htmlspecialchars($googleSheetUrl); ?>" target="_blank" 
                   class="px-6 py-3 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 font-semibold shadow-lg hover:scale-[1.02] transition-transform">
                    📊 Open Google Sheet
                </a>
            </div>
        </section>

        <!-- Existing Projects Overview -->
        <section class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-blue-900/20">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-slate-400">Project Overzicht</p>
                    <h2 class="text-2xl font-semibold text-slate-50">Bestaande Projecten</h2>
                    <p class="text-sm text-slate-400 mt-1"><?php echo count($projects); ?> project(en) gevonden in Google Sheets</p>
                </div>
            </div>
            
            <?php if (empty($projects)): ?>
                <div class="text-center py-8 text-slate-400">
                    <p>Nog geen projecten gevonden in Google Sheets.</p>
                    <p class="text-sm mt-2">Maak je eerste project aan met het formulier hieronder.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($projects as $project): ?>
                        <div class="rounded-lg border border-slate-800 bg-slate-800/50 p-4 hover:bg-slate-800 transition-colors">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-50 mb-1">
                                        <?php echo htmlspecialchars($project['restaurant_name']); ?>
                                    </h3>
                                    <?php if (!empty($project['page_title'])): ?>
                                        <p class="text-sm text-slate-300 mb-2">
                                            <?php echo htmlspecialchars($project['page_title']); ?>
                                        </p>
                                    <?php endif; ?>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <?php if (!empty($project['domain'])): ?>
                                            <span class="text-xs px-2 py-1 rounded bg-slate-700 text-slate-300">
                                                🌐 <?php echo htmlspecialchars($project['domain']); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="text-xs px-2 py-1 rounded bg-blue-600/20 text-blue-300">
                                            Rij <?php echo $project['row_number']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($project['orderli_link'])): ?>
                                <div class="mt-3 pt-3 border-t border-slate-700">
                                    <a href="<?php echo htmlspecialchars($project['orderli_link']); ?>" 
                                       target="_blank" 
                                       class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                        🔗 Orderli Link
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- New Project Form -->
        <section class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 shadow-2xl shadow-blue-900/20">
            <div class="mb-6">
                <p class="text-sm text-slate-400">Nieuw Project</p>
                <h2 class="text-2xl font-semibold text-slate-50">Maak nieuw project aan</h2>
                <p class="text-sm text-slate-400 mt-1">Vul het formulier in om een nieuwe rij toe te voegen aan de Google Sheet</p>
            </div>

            <?php if ($message): ?>
                <div class="mb-6 rounded-lg border <?php echo $success ? 'border-green-500/40 bg-green-500/10 text-green-100' : 'border-blue-500/40 bg-blue-500/10 text-blue-100'; ?> px-4 py-3">
                    <?php echo htmlspecialchars($message); ?>
                    <?php if (isset($_SESSION['download_file'])): ?>
                        <div class="mt-3">
                            <a href="?download=1" class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg font-semibold">
                                📥 Download CSV voor Google Sheets
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($webhookUrl)): ?>
                <div class="mb-6 rounded-lg border border-yellow-500/40 bg-yellow-500/10 text-yellow-100 px-4 py-3">
                    <p class="font-semibold mb-2">💡 Tip: Automatisch naar Google Sheets</p>
                    <p class="text-sm mb-2">Voor automatisch toevoegen aan Google Sheets, voeg een Google Apps Script webhook toe.</p>
                    <details class="text-sm">
                        <summary class="cursor-pointer font-semibold">📋 Instructies voor Google Apps Script</summary>
                        <ol class="list-decimal list-inside mt-2 space-y-1 text-xs">
                            <li>Open je Google Sheet</li>
                            <li>Ga naar Extensies → Apps Script</li>
                            <li>Plak het script uit <code class="bg-slate-800 px-1 rounded">google_apps_script.js</code></li>
                            <li>Deploy als Web App (Execute as: Me, Who has access: Anyone)</li>
                            <li>Kopieer de Web App URL en voeg toe aan <code class="bg-slate-800 px-1 rounded">admin_dashboard.php</code> (regel ~20)</li>
                        </ol>
                    </details>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="new_project">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="domain">Domain (Kolom A) *</label>
                        <input id="domain" name="domain" type="text" required placeholder="bijv. restaurant-naam.nl"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="restaurant_name">Restaurant Naam (Kolom B) *</label>
                        <input id="restaurant_name" name="restaurant_name" type="text" required placeholder="Bijv. Pizzeria Bella"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="page_title">Page Title/Headline (Kolom C) *</label>
                    <input id="page_title" name="page_title" type="text" required placeholder="Bijv. Welkom bij ons restaurant!"
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="orderli_link">Orderli Home Link (Kolom D) *</label>
                    <input id="orderli_link" name="orderli_link" type="url" required placeholder="https://orderli.home/restaurant-naam"
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="hero_description">Hero Beschrijving (Kolom E) *</label>
                    <textarea id="hero_description" name="hero_description" rows="2" required placeholder="Korte, pakkende beschrijving onder de titel"
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="about_text_1">Over Ons Tekst Deel 1 (Kolom F) *</label>
                        <textarea id="about_text_1" name="about_text_1" rows="3" required placeholder="Eerste alinea over het restaurant"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="about_text_2">Over Ons Tekst Deel 2 (Kolom G)</label>
                        <textarea id="about_text_2" name="about_text_2" rows="3" placeholder="Tweede alinea (optioneel)"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70"></textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="location_text">Locatie Tekst (Kolom H) *</label>
                    <textarea id="location_text" name="location_text" rows="2" required placeholder="Beschrijving van locatie en bezorggebied"
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70"></textarea>
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="opening_hours">Openingstijden (Kolom I)</label>
                    <textarea id="opening_hours" name="opening_hours" rows="4" placeholder="Ma: 11:00-22:00&#10;Di: 11:00-22:00&#10;..."
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70"></textarea>
                </div>

                <div>
                    <label class="block text-sm text-slate-300 mb-1" for="why_us_text">Waarom Ons Tekst (Kolom J) *</label>
                    <textarea id="why_us_text" name="why_us_text" rows="2" required placeholder="Waarom klanten voor dit restaurant moeten kiezen"
                        class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="logo_url">Logo URL (Kolom K)</label>
                        <input id="logo_url" name="logo_url" type="url" placeholder="https://example.com/logo.png"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="bezorging_tijd">Bezorging Tijd (Kolom L) *</label>
                        <input id="bezorging_tijd" name="bezorging_tijd" type="text" required placeholder="30-45 min"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1" for="gratis_bezorging">Gratis Bezorging Vanaf (Kolom M) *</label>
                        <input id="gratis_bezorging" name="gratis_bezorging" type="text" required placeholder="€15"
                            class="w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2 text-slate-50 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/70">
                    </div>
                </div>

                <div class="pt-4 flex gap-3 items-center">
                    <button type="button" onclick="autofillForm()"
                        class="px-6 py-3 rounded-lg bg-slate-700 hover:bg-slate-600 font-semibold transition-colors border border-slate-600">
                        ⚡ Autofill (behalve restaurant naam)
                    </button>
                    <button type="submit"
                        class="px-8 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 font-semibold shadow-lg shadow-blue-900/30 hover:scale-[1.01] transition-transform">
                        ➕ Nieuw Project Aanmaken
                    </button>
                </div>
                <p class="text-xs text-slate-400 mt-2">Na het aanmaken krijg je een CSV file die je kunt importeren in Google Sheets</p>
            </form>
        </section>
    </main>

    <script>
        function autofillForm() {
            // Restaurant naam blijft leeg (verplicht veld)
            document.getElementById('restaurant_name').value = '';
            
            // Vul alle andere velden met voorbeelddata
            document.getElementById('domain').value = 'voorbeeld-restaurant.nl';
            document.getElementById('page_title').value = 'Welkom bij ons restaurant!';
            document.getElementById('orderli_link').value = 'https://orderli.home/voorbeeld-restaurant';
            document.getElementById('hero_description').value = 'Bestel nu en krijg je favoriete gerechten snel thuisbezorgd. Vers bereid en heerlijk vers!';
            document.getElementById('about_text_1').value = 'Welkom bij ons restaurant! Wij serveren al jarenlang heerlijke, verse gerechten met passie en toewijding. Onze chef-koks gebruiken alleen de beste ingrediënten om elke maaltijd tot een culinaire ervaring te maken.';
            document.getElementById('about_text_2').value = 'Of je nu kiest voor een snelle lunch, een uitgebreid diner of een late night snack - wij zorgen ervoor dat elke hap een feestje is. Bestel nu via Orderli Home en geniet van onze gerechten in het comfort van je eigen huis!';
            document.getElementById('location_text').value = 'Bezoek ons op onze locatie of laat je bestelling bezorgen. Wij bezorgen in de hele stad en omgeving.';
            document.getElementById('opening_hours').value = 'Maandag: 11:00 - 22:00\nDinsdag: 11:00 - 22:00\nWoensdag: 11:00 - 22:00\nDonderdag: 11:00 - 22:00\nVrijdag: 11:00 - 23:00\nZaterdag: 11:00 - 23:00\nZondag: 12:00 - 21:00';
            document.getElementById('why_us_text').value = 'Vers bereid, snelle bezorging en altijd met een glimlach. Wij staan bekend om onze kwaliteit en service. Bestel vandaag nog en ervaar het verschil!';
            document.getElementById('logo_url').value = 'https://via.placeholder.com/150x50/dc2626/ffffff?text=LOGO';
            document.getElementById('bezorging_tijd').value = '30-45 min';
            document.getElementById('gratis_bezorging').value = '€15';
            
            // Focus op restaurant naam veld zodat gebruiker het direct kan invullen
            document.getElementById('restaurant_name').focus();
            
            // Toon melding
            alert('Formulier ingevuld! Vergeet niet de restaurant naam in te vullen (verplicht veld).');
        }
    </script>
</body>
</html>
