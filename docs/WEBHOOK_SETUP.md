# 🔗 Webhook Setup Instructies - Automatisch naar Google Sheets

## Stap 1: Open Google Apps Script

1. Open je Google Sheet: https://docs.google.com/spreadsheets/d/1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k/edit
2. Klik op **Extensies** (bovenaan)
3. Klik op **Apps Script**

## Stap 2: Plak de Code

1. Verwijder alle bestaande code in de editor
2. Open het bestand `google_apps_script.js` uit dit project
3. Kopieer ALLE code
4. Plak het in de Google Apps Script editor

## Stap 3: Deploy als Web App

1. Klik op **Deploy** (rechtsboven)
2. Klik op **New deployment**
3. Klik op het **tandwiel icoon** (⚙️) naast "Select type"
4. Kies **Web app**
5. Vul in:
   - **Description:** Orderli Webhook (optioneel)
   - **Execute as:** Me
   - **Who has access:** Anyone
6. Klik op **Deploy**
7. **BELANGRIJK:** Autoriseer de app wanneer daarom wordt gevraagd
   - Klik op "Authorize access"
   - Kies je Google account
   - Klik op "Advanced"
   - Klik op "Go to [Project Name] (unsafe)"
   - Klik op "Allow"

## Stap 4: Kopieer de Web App URL

1. Na het deployen zie je een scherm met "Web app"
2. Kopieer de **Web App URL** (bijv. `https://script.google.com/macros/s/...`)
3. Deze URL heb je nodig voor de volgende stap

## Stap 5: Voeg URL toe aan admin_dashboard.php

1. Open `admin_dashboard.php` in je editor
2. Zoek regel ~20 waar staat: `$webhookUrl = '';`
3. Plak je Web App URL tussen de quotes:
   ```php
   $webhookUrl = 'https://script.google.com/macros/s/JOUW_URL_HIER/exec';
   ```
4. Sla het bestand op

## Stap 6: Test!

1. Ga naar http://localhost:8000/admin_dashboard.php
2. Maak een nieuw project aan
3. Vul het formulier in
4. Klik op "Nieuw Project Aanmaken"
5. Check je Google Sheet - de nieuwe rij zou automatisch moeten verschijnen! 🎉

## Troubleshooting

**Als het niet werkt:**
- Check of de Web App URL correct is (moet eindigen op `/exec`)
- Check of "Who has access" op "Anyone" staat
- Check of je de app hebt geautoriseerd
- Check de Google Apps Script logs (Executions tab)

**Test de webhook:**
- Open je Web App URL in de browser
- Je zou moeten zien: "Google Apps Script Webhook is active!"
