# Setup Instructies voor Nieuwe Laptop

Dit project heeft PHP nodig om te draaien. Volg deze stappen om alles te installeren:

## Stap 1: Installeer Homebrew (als je het nog niet hebt)

Open Terminal en voer uit:

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

Volg de instructies op het scherm. Je wordt gevraagd om je wachtwoord in te voeren.

Na installatie, voeg Homebrew toe aan je PATH (als dat nog niet automatisch is gebeurd):

```bash
echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zshrc
eval "$(/opt/homebrew/bin/brew shellenv)"
```

## Stap 2: Installeer PHP

```bash
brew install php
```

## Stap 3: Verifieer de installatie

```bash
php --version
```

Je zou iets moeten zien zoals: `PHP 8.x.x`

## Stap 4: Start de servers

Ga naar de project directory:

```bash
cd /Users/christopher/Documents/GitHub/Orderli-Live
```

Start de eerste server (port 8000):

```bash
php -S localhost:8000 router_8000.php
```

Open een **nieuwe terminal** en start de tweede server (port 8001):

```bash
cd /Users/christopher/Documents/GitHub/Orderli-Live
php -S localhost:8001 router_8001.php
```

## Stap 5: Open in browser

- Generator: http://localhost:8000
- Viewer: http://localhost:8001

## Alternatief: Gebruik het setup script

Je kunt ook het `setup.sh` script uitvoeren (zie hieronder).
