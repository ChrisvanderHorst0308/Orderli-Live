# ChatGPT Prompt: Google Sheets Content Generator voor Bestelpagina

Kopieer en plak deze prompt naar ChatGPT:

---

**Ik heb een Google Sheets bestand dat ik moet vullen met content voor een converterende bestelpagina voor restaurants. De pagina gebruikt PHP om dynamisch content uit de Google Sheets te halen.**

## Context
Dit is een bestelpagina (landing page) die bezoekers moet converteren om te klikken op een "Bestel via Orderli Home" knop. De pagina heeft:
- Een hero sectie met titel en beschrijving
- Een "Over Ons" sectie met informatie over het restaurant
- Locatie, openingstijden en "Waarom Ons" informatie
- Alle content wordt dynamisch uit Google Sheets gehaald

## Google Sheets Structuur

**Rij 1: Headers** (wordt overgeslagen door de code)
| A | B | C | D | E | F | G | H | I | J | K | L | M |
|---|---|---|---|---|---|---|---|---|---|---|---|---|
| Domain | Restaurant | Title | Link | Hero | About1 | About2 | Location | Hours | Why Us | Logo | Bezorging | Gratis |

**Rij 2 (A2) en verder: Data rijen**

### Kolom Details:

**Kolom A - Domain name:**
- Het domain waar de pagina op draait (bijv. "live.cenconcepts.nl" of "localhost")
- Wordt gebruikt om de juiste rij te vinden
- **Voorbeeld:** `live.cenconcepts.nl`

**Kolom B - Restaurant naam:**
- Naam van het restaurant (optioneel, wordt momenteel niet gebruikt in de pagina maar kan handig zijn voor overzicht)
- **Voorbeeld:** `Pizzeria Bella`

**Kolom C - Page title/headline:**
- De grote titel die prominent bovenaan de pagina verschijnt
- Moet converterend en aantrekkelijk zijn
- Maximaal 8-10 woorden
- **Voorbeeld:** `Welkom bij Pizzeria Bella!`

**Kolom D - Orderli Home link:**
- De volledige URL naar de bestelpagina op Orderli Home
- Moet beginnen met https://
- **Voorbeeld:** `https://orderli.home/pizzeria-bella`

**Kolom E - Hero beschrijving:**
- Korte, pakkende beschrijving onder de titel
- 1-2 zinnen die mensen aanzetten tot bestellen
- Focus op versheid, snelheid, kwaliteit
- **Voorbeeld:** `Bestel nu en krijg je favoriete pizza's binnen 30 minuten thuisbezorgd. Vers uit de oven, altijd heerlijk!`

**Kolom F - Over ons tekst deel 1:**
- Eerste alinea van de "Over Ons" sectie
- Vertel over het restaurant, de passie, de geschiedenis
- 2-3 zinnen
- **Voorbeeld:** `Welkom bij Pizzeria Bella! Al sinds 2010 serveren wij authentieke Italiaanse pizza's met de beste ingrediënten. Onze chef-koks hebben jarenlange ervaring en passen traditionele recepten toe met een moderne twist.`

**Kolom G - Over ons tekst deel 2:**
- Tweede alinea van de "Over Ons" sectie
- Focus op wat het restaurant uniek maakt en call-to-action
- 2-3 zinnen
- **Voorbeeld:** `Of je nu kiest voor een klassieke Margherita, een volle Quattro Stagioni of een van onze speciale pizza's - elke hap is een feestje. Bestel nu via Orderli Home en geniet van onze heerlijke pizza's in het comfort van je eigen huis!`

**Kolom H - Locatie tekst:**
- Beschrijving van waar het restaurant zich bevindt en bezorggebied
- 1-2 zinnen
- **Voorbeeld:** `Bezoek ons op onze locatie in het centrum of laat je bestelling bezorgen. Wij bezorgen in Amsterdam en omgeving binnen 30-45 minuten.`

**Kolom I - Openingstijden:**
- Openingstijden per dag (kan leeg gelaten worden voor standaard schema)
- Format: Elke dag op een nieuwe regel, of als doorlopende tekst
- **Voorbeeld (optie 1 - doorlopend):** `Maandag t/m Donderdag: 11:00 - 22:00 | Vrijdag & Zaterdag: 11:00 - 23:00 | Zondag: 12:00 - 21:00`
- **Voorbeeld (optie 2 - met enters):** 
```
Maandag: 11:00 - 22:00
Dinsdag: 11:00 - 22:00
Woensdag: 11:00 - 22:00
Donderdag: 11:00 - 22:00
Vrijdag: 11:00 - 23:00
Zaterdag: 11:00 - 23:00
Zondag: 12:00 - 21:00
```

**Kolom J - Waarom Ons tekst:**
- Korte tekst die uitlegt waarom klanten voor dit restaurant moeten kiezen
- Focus op unieke selling points
- 2-3 zinnen
- **Voorbeeld:** `Vers bereid met dagverse ingrediënten, snelle bezorging en altijd met een glimlach. Wij staan bekend om onze authentieke smaken en uitstekende service. Bestel vandaag nog en ervaar het verschil!`

**Kolom K - Logo URL:**
- URL naar het logo van het restaurant (optioneel)
- Moet een volledige URL zijn (https://...)
- Als leeg gelaten, wordt een placeholder gebruikt
- **Voorbeeld:** `https://example.com/logo.png`
- **Of leeg laten:** (lege cel)

**Kolom L - Bezorging tijd:**
- De bezorgtijd die getoond wordt in de header
- Kort en duidelijk
- **Voorbeeld:** `30-45 min` of `45-60 min`

**Kolom M - Gratis bezorging vanaf:**
- Vanaf welk bedrag de bezorging gratis is
- Moet beginnen met €
- **Voorbeeld:** `€15` of `€20`

## Opdracht

**Genereer voor mij 3 verschillende restaurant rijen (rij 2, 3 en 4) met realistische, converterende content voor:**

1. **Een Italiaans restaurant (pizzeria)**
2. **Een Aziatisch restaurant (sushi/Thais)**
3. **Een burger restaurant**

Voor elk restaurant:
- Gebruik een uniek domain in kolom A (bijv. `pizzeria-bella.nl`, `sushi-palace.nl`, `burger-king.nl`)
- Maak converterende, aantrekkelijke teksten die mensen aanzetten tot bestellen
- Zorg dat alle teksten in het Nederlands zijn
- Maak de content authentiek en geloofwaardig
- Focus op versheid, snelheid en kwaliteit
- Gebruik emotie en voordelen in plaats van alleen features

**Format: Geef de content terug in een tabel formaat zodat ik het direct kan kopiëren naar Google Sheets.**

---

**Eind van prompt**

