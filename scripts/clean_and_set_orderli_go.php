<?php
// Script om de Google Sheet op te schonen en alleen Orderli GO als eerste rij te zetten
// Met het juiste logo: https://i.ibb.co/wN1YhqLD/Orderli-logo-oranje-1.png

$webhookUrl = 'https://script.google.com/macros/s/AKfycbwcd4_gcHouyoPeToIXD8xWQkQCqeC52GNB_8wjBI4PX_GMKlWdE81HvqVoukvnikSarg/exec';

// Orderli GO preset data met het nieuwe logo
$rowData = [
    'orderli-go.nl',  // Domain (Kolom A)
    'Orderli GO',     // Restaurant Naam (Kolom B)
    'Welkom bij Orderli GO!',  // Page Title (Kolom C)
    'https://orderli.home/orderli-go',  // Orderli Link (Kolom D)
    'Bestel nu en krijg je favoriete gerechten snel thuisbezorgd. Vers bereid en heerlijk vers!',  // Hero Beschrijving (Kolom E)
    'Welkom bij Orderli GO! Wij serveren al jarenlang heerlijke, verse gerechten met passie en toewijding. Onze chef-koks gebruiken alleen de beste ingrediënten om elke maaltijd tot een culinaire ervaring te maken.',  // Over Ons Tekst Deel 1 (Kolom F)
    'Of je nu kiest voor een snelle lunch, een uitgebreid diner of een late night snack - wij zorgen ervoor dat elke hap een feestje is. Bestel nu via Orderli Home en geniet van onze gerechten in het comfort van je eigen huis!',  // Over Ons Tekst Deel 2 (Kolom G)
    'Bezoek ons op onze locatie of laat je bestelling bezorgen. Wij bezorgen in de hele stad en omgeving.',  // Locatie Tekst (Kolom H)
    "Maandag: 11:00 - 22:00\nDinsdag: 11:00 - 22:00\nWoensdag: 11:00 - 22:00\nDonderdag: 11:00 - 22:00\nVrijdag: 11:00 - 23:00\nZaterdag: 11:00 - 23:00\nZondag: 12:00 - 21:00",  // Openingstijden (Kolom I)
    'Vers bereid, snelle bezorging en altijd met een glimlach. Wij staan bekend om onze kwaliteit en service. Bestel vandaag nog en ervaar het verschil!',  // Waarom Ons Tekst (Kolom J)
    'https://i.ibb.co/wN1YhqLD/Orderli-logo-oranje-1.png',  // Logo URL (Kolom K) - NIEUWE LOGO
    '30-45 min',  // Bezorging Tijd (Kolom L)
    '€15'  // Gratis Bezorging Vanaf (Kolom M)
];

echo "🔄 Opschonen van Google Sheet en toevoegen van Orderli GO als eerste rij...\n\n";

// Send to Google Sheets via webhook
// We gebruiken 'clear_and_add' als actie om de sheet op te schonen
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'action' => 'clear_and_add',
    'row' => $rowData,
    'insert_at' => 2  // Insert at row 2 (after header)
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "HTTP Code: " . $httpCode . "\n";
echo "Response: " . $response . "\n\n";

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if (isset($result['success']) && $result['success']) {
        echo "✅ Google Sheet succesvol opgeschoond!\n";
        echo "✅ Orderli GO toegevoegd als eerste rij met het nieuwe logo.\n";
        echo "\n📋 Logo URL: https://i.ibb.co/wN1YhqLD/Orderli-logo-oranje-1.png\n";
    } else {
        echo "⚠️ De webhook heeft mogelijk geen 'clear_and_add' functionaliteit.\n";
        echo "Je moet de sheet handmatig opschonen:\n";
        echo "1. Open de Google Sheet\n";
        echo "2. Verwijder alle rijen behalve de header (rij 1)\n";
        echo "3. Voeg de Orderli GO rij toe als rij 2\n";
        echo "\nOf gebruik het admin dashboard om een nieuwe rij toe te voegen.\n";
    }
} else {
    echo "⚠️ Fout bij opschonen van Google Sheet. HTTP Code: " . $httpCode . "\n";
    echo "\n📝 HANDMATIGE INSTRUCTIES:\n";
    echo "1. Open de Google Sheet: https://docs.google.com/spreadsheets/d/1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k/edit\n";
    echo "2. Selecteer alle rijen behalve rij 1 (header) en verwijder ze\n";
    echo "3. Voeg deze data toe als rij 2:\n\n";
    echo "Domain: orderli-go.nl\n";
    echo "Restaurant Naam: Orderli GO\n";
    echo "Page Title: Welkom bij Orderli GO!\n";
    echo "Orderli Link: https://orderli.home/orderli-go\n";
    echo "Hero Beschrijving: Bestel nu en krijg je favoriete gerechten snel thuisbezorgd. Vers bereid en heerlijk vers!\n";
    echo "Over Ons Tekst Deel 1: Welkom bij Orderli GO! Wij serveren al jarenlang heerlijke, verse gerechten met passie en toewijding. Onze chef-koks gebruiken alleen de beste ingrediënten om elke maaltijd tot een culinaire ervaring te maken.\n";
    echo "Over Ons Tekst Deel 2: Of je nu kiest voor een snelle lunch, een uitgebreid diner of een late night snack - wij zorgen ervoor dat elke hap een feestje is. Bestel nu via Orderli Home en geniet van onze gerechten in het comfort van je eigen huis!\n";
    echo "Locatie Tekst: Bezoek ons op onze locatie of laat je bestelling bezorgen. Wij bezorgen in de hele stad en omgeving.\n";
    echo "Openingstijden: (zie CSV bestand)\n";
    echo "Waarom Ons Tekst: Vers bereid, snelle bezorging en altijd met een glimlach. Wij staan bekend om onze kwaliteit en service. Bestel vandaag nog en ervaar het verschil!\n";
    echo "Logo URL: https://i.ibb.co/wN1YhqLD/Orderli-logo-oranje-1.png\n";
    echo "Bezorging Tijd: 30-45 min\n";
    echo "Gratis Bezorging Vanaf: €15\n";
    echo "\nOf gebruik het CSV bestand: data/orderli_go_preset.csv\n";
}
