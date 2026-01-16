# 📋 Overzicht van alle bestanden en functionaliteit

## 🎯 Hoofdfunctionaliteit

### **1. index.php** - Bestelpagina (Hoofdpagina)
**Wat doet het:**
- Haalt restaurant data uit Google Sheets op basis van domain
- Toont een converterende bestelpagina met:
  - Hero sectie met titel en bestelknop
  - Benefits bar (snelle bezorging, gratis, etc.)
  - "Over Ons" sectie met restaurant informatie
  - Locatie, openingstijden, "Waarom Ons" cards
- Gebruikt Tailwind CSS en animaties
- Bestelknop linkt naar Orderli Home (uit Google Sheets kolom D)

**Kolommen gebruikt:**
- A: Domain (matching)
- C: Page title
- D: Orderli Home link
- E: Hero beschrijving
- F-G: Over ons teksten
- H: Locatie tekst
- I: Openingstijden
- J: Waarom ons tekst
- K: Logo URL
- L: Bezorging tijd
- M: Gratis bezorging vanaf

---

### **2. generator.php** - Webflow Concept Generator
**Wat doet het:**
- Haalt restaurant data uit Google Sheets (zelfde als index.php)
- Genereert automatisch een Webflow homepage concept
- Maakt 8 verschillende secties:
  1. Hero (1.15) - Grote hero met achtergrondafbeelding
  2. Over Ons (6.3) - Tekst + afbeelding
  3. Features (4.3) - Grid met 4 feature cards
  4. Menu Preview (2.5) - Grid met menu items
  5. Testimonials (7.2) - 3 testimonial cards
  6. Call to Action (5.1) - CTA banner
  7. Galerij (3.4) - Sfeerimpressies
  8. Contact (8.2) - Contact formulier
- Toont alles in een tabel formaat
- Slaat concept op in `generated_concept.json`
- Heeft knop naar viewer (localhost:8001)

**Draait op:** localhost:8000/generator.php

---

### **3. viewer.php** - Visuele Preview
**Wat doet het:**
- Leest `generated_concept.json`
- Toont visuele preview van alle gegenereerde secties
- Mooie styling met animaties
- Responsive design

**Draait op:** localhost:8001

---

### **4. admin_login.php** - Admin Login
**Wat doet het:**
- Login pagina voor admin dashboard
- Gebruikersnaam: `chris`
- Wachtwoord: `Orderli123`
- Gebruikt PHP sessions voor authenticatie

**Draait op:** localhost:8000/admin_login.php

---

### **5. admin_dashboard.php** - Admin Dashboard
**Wat doet het:**
- Dashboard na login
- 3 hoofdonderdelen:
  1. **Nieuwe prompt aanmaken** - Formulier om prompts toe te voegen
  2. **Opgeslagen prompts** - Overzicht van alle prompts uit `prompts.json`
  3. **Snelkoppelingen** - Links naar:
     - Generator (localhost:8000)
     - Viewer (localhost:8001)
     - JSON output (generated_concept.json)
- Shadcn-achtige styling (donkere theme)

**Draait op:** localhost:8000/admin_dashboard.php

---

## 🔧 Technische bestanden

### **6. router_8000.php** - Router voor Port 8000
**Wat doet het:**
- Routeert requests op localhost:8000
- Routes:
  - `/` of `/index.php` → generator.php
  - `/generator.php` → generator.php
  - `/admin_login.php` → admin_login.php
  - `/admin_dashboard.php` → admin_dashboard.php
  - `/generated_concept.json` → JSON file

**Gebruikt door:** PHP development server op port 8000

---

### **7. router_8001.php** - Router voor Port 8001
**Wat doet het:**
- Routeert requests op localhost:8001
- Alle routes → viewer.php

**Gebruikt door:** PHP development server op port 8001

---

## 📄 Data bestanden

### **8. prompts.json** - Opgeslagen Prompts
**Wat doet het:**
- Slaat prompts op die via admin dashboard zijn aangemaakt
- JSON formaat met: title, content, created_at

**Voorbeeld:**
```json
[
  {
    "title": "Postiano",
    "content": "Een foodtruck die pizzas verkoopt bij outlet roermond",
    "created_at": "2025-12-24 10:32:54"
  }
]
```

---

### **9. generated_concept.json** - Gegenereerd Concept
**Wat doet het:**
- Slaat het gegenereerde Webflow concept op
- Bevat: restaurant data + alle 8 secties
- Wordt gebruikt door viewer.php

**Gemaakt door:** generator.php
**Gebruikt door:** viewer.php

---

## 📚 Documentatie bestanden

### **10. CHATGPT_PROMPT.md** - Uitgebreide ChatGPT Prompt
**Wat doet het:**
- Uitgebreide prompt voor ChatGPT
- Uitleg van alle kolommen
- Voorbeelden per kolom
- Markdown formaat

**Gebruik:** Kopieer naar ChatGPT om content te genereren

---

### **11. CHATGPT_PROMPT_SIMPLE.txt** - Simpele ChatGPT Prompt
**Wat doet het:**
- Korte versie van de prompt
- Direct klaar om te kopiëren
- Tekst formaat

**Gebruik:** Kopieer naar ChatGPT om content te genereren

---

### **12. README_GENERATOR.md** - Generator Documentatie
**Wat doet het:**
- Uitleg over het generator systeem
- Hoe servers te starten
- Features overzicht

---

### **13. DEMO.md** - Demo Overzicht
**Wat doet het:**
- Demo stappen
- Snelkoppelingen
- Test scenario's

---

## 🔄 Data Flow

```
Google Sheets (1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k)
    ↓
index.php → Bestelpagina (toont content)
    ↓
generator.php → Genereert Webflow concept
    ↓
generated_concept.json → Slaat concept op
    ↓
viewer.php → Toont visuele preview
```

---

## 🚀 Servers

**Port 8000:**
- Admin login/dashboard
- Generator
- Router: router_8000.php

**Port 8001:**
- Viewer
- Router: router_8001.php

---

## 📊 Google Sheets Structuur

**Sheet ID:** `1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k`

**Kolommen:**
- A: Domain name
- B: Restaurant naam
- C: Page title/headline
- D: Orderli Home link URL
- E: Hero beschrijving
- F: Over ons tekst deel 1
- G: Over ons tekst deel 2
- H: Locatie tekst
- I: Openingstijden
- J: Waarom Ons tekst
- K: Logo URL
- L: Bezorging tijd
- M: Gratis bezorging vanaf

**Rij 1:** Headers (wordt overgeslagen)
**Rij 2+:** Data rijen

---

## ✅ Wat werkt

1. ✅ Bestelpagina (index.php) - Haalt data uit Google Sheets
2. ✅ Generator (generator.php) - Genereert Webflow concept
3. ✅ Viewer (viewer.php) - Toont visuele preview
4. ✅ Admin Dashboard - Login + prompt beheer
5. ✅ Routers - Correcte routing voor beide servers

---

## 🗑️ Bestanden die mogelijk opgeschoond kunnen worden

- `CHATGPT_PROMPT.md` - Kan blijven (documentatie)
- `CHATGPT_PROMPT_SIMPLE.txt` - Kan blijven (documentatie)
- `README_GENERATOR.md` - Kan blijven (documentatie)
- `DEMO.md` - Kan blijven (documentatie)
- `OVERZICHT.md` - Dit bestand (nieuw)

**Alle bestanden hebben een functie!**
