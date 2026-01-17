# 🎬 Demo Overzicht - Orderli Live System

## ✅ Status Check
- ✅ **Server 8000** draait (Admin Dashboard & Generator)
- ✅ **Server 8001** draait (Viewer)
- ✅ **Prompts** opgeslagen: 1 prompt ("Postiano")

---

## 🚀 Demo Stappen

### **Stap 1: Admin Dashboard (localhost:8000)**

**URL:** http://localhost:8000/admin_login.php

**Login gegevens:**
- **Gebruikersnaam:** `chris`
- **Wachtwoord:** `Orderli123`

**Wat je ziet:**
- Login pagina met shadcn-achtige styling
- Donkere achtergrond, moderne UI

**Na inloggen:**
- Dashboard met 3 secties:
  1. **Nieuwe prompt aanmaken** - Formulier om prompts toe te voegen
  2. **Opgeslagen prompts** - Overzicht van alle prompts (nu: "Postiano")
  3. **Snelkoppelingen** - Links naar Generator, Viewer, JSON

---

### **Stap 2: Generator (localhost:8000/generator.php)**

**URL:** http://localhost:8000/generator.php

**Wat gebeurt er:**
- Haalt automatisch restaurant data uit Google Sheets
- Genereert Webflow concept content
- Toont tabel met 8 secties:
  - Hero (1.15)
  - Over Ons (6.3)
  - Features (4.3)
  - Menu Preview (2.5)
  - Testimonials (7.2)
  - Call to Action (5.1)
  - Galerij (3.4)
  - Contact (8.2)

**Output:**
- Tabel met alle sectie details
- Knop naar Viewer (localhost:8001)
- Concept opgeslagen in `generated_concept.json`

---

### **Stap 3: Viewer (localhost:8001)**

**URL:** http://localhost:8001/viewer.php

**Wat je ziet:**
- Visuele preview van alle gegenereerde secties
- Hero met achtergrondafbeelding
- Over Ons sectie met tekst en afbeelding
- Features grid met 4 cards
- Menu preview met 6 items
- Testimonials met sterren
- CTA banner
- Animaties en moderne styling

---

## 📋 Huidige Data

### **Opgeslagen Prompt:**
```json
{
  "title": "Postiano",
  "content": "Een foodtruck die pizzas verkoopt bij outlet roermond",
  "created_at": "2025-12-24 10:32:54"
}
```

### **Google Sheets Data:**
- Sheet ID: `1fSfBwM_aG1dCCdXAxIL44nI8kXSMN0cNVJX-cTAtS6k`
- Matching op domain in kolom A
- Content uit kolommen B-M

---

## 🎯 Functionaliteiten

### **Admin Dashboard:**
- ✅ Login systeem (chris / Orderli123)
- ✅ Prompt beheer (aanmaken, bekijken)
- ✅ Snelkoppelingen naar alle pagina's
- ✅ Shadcn-achtige styling

### **Generator:**
- ✅ Haalt data uit Google Sheets
- ✅ Genereert Webflow concept
- ✅ 8 verschillende secties
- ✅ Unsplash afbeeldingen
- ✅ Converterende teksten

### **Viewer:**
- ✅ Visuele preview
- ✅ Alle secties getoond
- ✅ Animaties
- ✅ Responsive design

---

## 🔗 Snelkoppelingen

| Pagina | URL | Beschrijving |
|--------|-----|--------------|
| **Admin Login** | http://localhost:8000/admin_login.php | Login pagina |
| **Admin Dashboard** | http://localhost:8000/admin_dashboard.php | Dashboard (na login) |
| **Generator** | http://localhost:8000/generator.php | Webflow concept generator |
| **Viewer** | http://localhost:8001/viewer.php | Visuele preview |
| **JSON Output** | http://localhost:8000/generated_concept.json | Raw JSON data |

---

## 📝 Test Scenario

1. **Open** http://localhost:8000/admin_login.php
2. **Login** met `chris` / `Orderli123`
3. **Bekijk** opgeslagen prompt "Postiano"
4. **Maak** nieuwe prompt aan (optioneel)
5. **Ga naar** Generator via snelkoppeling
6. **Zie** gegenereerde Webflow concept tabel
7. **Klik** op knop naar Viewer
8. **Bekijk** visuele preview op localhost:8001

---

## 🎨 Styling

- **Admin Dashboard:** Shadcn-achtige donkere theme
- **Generator:** Tailwind CSS met animaties
- **Viewer:** Modern design met gradient backgrounds
- **Login:** Clean, minimal design

---

## 💾 Bestanden

- `admin_login.php` - Login pagina
- `admin_dashboard.php` - Dashboard
- `generator.php` - Concept generator
- `viewer.php` - Visuele preview
- `router_8000.php` - Router voor port 8000
- `router_8001.php` - Router voor port 8001
- `prompts.json` - Opgeslagen prompts
- `generated_concept.json` - Gegenereerd concept

---

**🎉 Alles is klaar voor gebruik!**
