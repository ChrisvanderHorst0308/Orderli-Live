# Webflow Concept Generator

Dit systeem simuleert de Custom GPT prompt voor het genereren van Webflow-concepten voor restaurant websites.

## 🚀 Hoe te gebruiken

### Stap 1: Start de servers

Beide servers zijn al gestart:
- **localhost:8000** - Generator pagina
- **localhost:8001** - Viewer pagina

### Stap 2: Open de generator

Ga naar: **http://localhost:8000**

De generator:
- Haalt automatisch restaurant data uit je Google Sheets
- Genereert een complete Webflow homepage opzet
- Toont de content in een mooie tabel
- Slaat het concept op in `generated_concept.json`

### Stap 3: Bekijk het concept

Klik op de knop **"🚀 Bekijk Concept op Localhost:8001"** of ga direct naar:
**http://localhost:8001**

De viewer toont:
- Een visuele preview van alle secties
- Hero sectie met achtergrondafbeelding
- Over Ons sectie
- Features grid
- Menu preview
- Testimonials
- CTA sectie
- En meer...

## 📋 Wat wordt gegenereerd?

Het systeem genereert 8 verschillende secties:

1. **Hero (1.15)** - Grote hero met achtergrondafbeelding en CTA
2. **Over Ons (6.3)** - Tekst links, afbeelding rechts
3. **Features (4.3)** - Grid met 4 feature cards
4. **Menu Preview (2.5)** - Grid met menu items
5. **Testimonials (7.2)** - 3 testimonial cards
6. **Call to Action (5.1)** - Prominente CTA banner
7. **Galerij (3.4)** - Sfeerimpressies
8. **Contact (8.2)** - Contact formulier sectie

## 📊 Google Sheets Structuur

De generator haalt data uit je Google Sheets:
- **Kolom A**: Domain (voor matching)
- **Kolom B**: Restaurant naam
- **Kolom C**: Page title/headline
- **Kolom D**: Orderli Home link
- **Kolom E**: Hero beschrijving
- **Kolom F**: Over ons tekst deel 1
- **Kolom G**: Over ons tekst deel 2
- En meer...

## 🎨 Features

- ✅ Automatische content generatie op basis van restaurant data
- ✅ Webflow sectie types (1.15, 4.3, 7.2, etc.)
- ✅ Unsplash afbeeldingen voor restaurant/food fotografie
- ✅ Converterende teksten en call-to-actions
- ✅ Mooie visuele preview op localhost:8001
- ✅ Tabel formaat klaar om te kopiëren naar Webflow

## 📝 Bestanden

- `generator.php` - Generator pagina (localhost:8000)
- `viewer.php` - Viewer pagina (localhost:8001)
- `router_8000.php` - Router voor port 8000
- `router_8001.php` - Router voor port 8001
- `generated_concept.json` - Opgeslagen concept data

## 🔄 Herstarten servers

Als je de servers opnieuw moet starten:

```bash
# Stop bestaande servers
lsof -ti:8000 | xargs kill -9
lsof -ti:8001 | xargs kill -9

# Start generator (port 8000)
cd /path/to/orderli-live
php -S localhost:8000 router_8000.php

# Start viewer (port 8001) - in nieuwe terminal
cd /path/to/orderli-live
php -S localhost:8001 router_8001.php
```

## 💡 Tips

- De generator gebruikt de data uit je Google Sheets op basis van het huidige domain
- Als je op `localhost:8000` draait, zoekt het naar "localhost" in kolom A
- Voeg een rij toe aan je Google Sheets met "localhost" in kolom A om te testen
- Alle gegenereerde content is klaar om te kopiëren naar Webflow's "Template to Complete"

