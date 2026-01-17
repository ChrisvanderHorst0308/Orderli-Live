# 📋 Stap-voor-stap Instructies

## Stap 1: Open Terminal

1. Druk op `Cmd + Spatie` (om Spotlight te openen)
2. Type: `Terminal`
3. Druk op Enter

## Stap 2: Ga naar je project folder

Kopieer en plak dit in Terminal:

```bash
cd /Users/christopher/Documents/GitHub/Orderli-Live
```

Druk op Enter.

## Stap 3: Installeer alles automatisch

Kopieer en plak dit in Terminal:

```bash
./auto_setup.sh
```

Druk op Enter.

**Wat gebeurt er nu:**
- Het script vraagt om je **wachtwoord** (voor Homebrew installatie)
- Type je wachtwoord en druk op Enter
- Homebrew wordt geïnstalleerd (dit kan 5-10 minuten duren)
- PHP wordt automatisch geïnstalleerd
- De servers worden automatisch gestart

## Stap 4: Wacht tot alles klaar is

Je ziet berichten zoals:
- ✅ Homebrew is geïnstalleerd
- ✅ PHP is geïnstalleerd
- ✅ Server 1 gestart
- ✅ Server 2 gestart

## Stap 5: Open je browser

Als alles klaar is, open je browser en ga naar:

- **Generator**: http://localhost:8000
- **Viewer**: http://localhost:8001

---

## 🆘 Problemen?

### Als het script niet werkt:

**Optie A: Handmatig installeren**

1. Installeer Homebrew:
```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

2. Installeer PHP:
```bash
brew install php
```

3. Start servers:
```bash
./start_servers.sh
```

### Als de servers niet starten:

Check of PHP werkt:
```bash
php --version
```

Als je een versie ziet (bijv. "PHP 8.x.x"), dan werkt het. Start dan handmatig:
```bash
./start_servers.sh
```

### Servers stoppen:

```bash
./stop_servers.sh
```

---

## ✅ Klaar!

Als alles werkt, zie je:
- ✅ Beide servers draaien
- ✅ Je kunt http://localhost:8000 en http://localhost:8001 openen
