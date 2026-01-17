<?php
// Script om Orderli GO preset toe te voegen aan Google Sheet
// Dit voegt een nieuwe rij toe helemaal boven aan (als eerste data rij)

$webhookUrl = 'https://script.google.com/macros/s/AKfycbwcd4_gcHouyoPeToIXD8xWQkQCqeC52GNB_8wjBI4PX_GMKlWdE81HvqVoukvnikSarg/exec';

// Orderli GO preset data
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
    'https://i.ibb.co/wN1YhqLD/Orderli-logo-oranje-1.png',  // Logo URL (Kolom K)
    '30-45 min',  // Bezorging Tijd (Kolom L)
    '€15'  // Gratis Bezorging Vanaf (Kolom M)
];

// Send to Google Sheets via webhook
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['row' => $rowData, 'insert_at' => 2])); // Insert at row 2 (after header)
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode === 200) {
    echo "✅ Orderli GO preset succesvol toegevoegd aan Google Sheet!\n";
    echo "Response: " . $response . "\n";
} else {
    echo "⚠️ Fout bij toevoegen aan Google Sheet. HTTP Code: " . $httpCode . "\n";
    echo "Response: " . $response . "\n";
    echo "\nJe kunt de data handmatig toevoegen via het admin dashboard of de CSV importeren.\n";
    echo "CSV bestand staat in: data/orderli_go_preset.csv\n";
}
