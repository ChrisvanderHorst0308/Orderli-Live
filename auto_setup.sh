#!/bin/bash

# Automatische setup voor Orderli-Live
# Dit script installeert alles wat nodig is

set -e

echo "🚀 Orderli-Live Automatische Setup"
echo "===================================="
echo ""

# Check of Homebrew al geïnstalleerd is
if command -v brew &> /dev/null; then
    echo "✅ Homebrew is al geïnstalleerd"
    brew --version
else
    echo "📦 Homebrew installeren..."
    echo "   (Je wordt gevraagd om je wachtwoord)"
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    
    # Voeg Homebrew toe aan PATH voor Apple Silicon Macs
    if [ -f "/opt/homebrew/bin/brew" ]; then
        echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zshrc
        eval "$(/opt/homebrew/bin/brew shellenv)"
    # Voor Intel Macs
    elif [ -f "/usr/local/bin/brew" ]; then
        echo 'eval "$(/usr/local/bin/brew shellenv)"' >> ~/.zshrc
        eval "$(/usr/local/bin/brew shellenv)"
    fi
fi

# Wacht even zodat Homebrew beschikbaar is
sleep 2

# Check of PHP al geïnstalleerd is
if command -v php &> /dev/null; then
    echo ""
    echo "✅ PHP is al geïnstalleerd"
    php --version
else
    echo ""
    echo "📦 PHP installeren via Homebrew..."
    brew install php
fi

echo ""
echo "✅ Installatie voltooid!"
echo ""
echo "🔍 Controleren of alles werkt..."
php --version
echo ""

# Vraag of de gebruiker de servers wil starten
echo "Wil je de servers nu starten? (j/n)"
read -r response
if [[ "$response" =~ ^[JjYy]$ ]]; then
    echo ""
    echo "🚀 Servers starten..."
    echo ""
    echo "⚠️  BELANGRIJK: Je hebt 2 terminals nodig!"
    echo ""
    echo "Terminal 1 (Generator - port 8000):"
    echo "  cd $(pwd)"
    echo "  php -S localhost:8000 router_8000.php"
    echo ""
    echo "Terminal 2 (Viewer - port 8001):"
    echo "  cd $(pwd)"
    echo "  php -S localhost:8001 router_8001.php"
    echo ""
    
    # Start de eerste server in de achtergrond
    echo "Starten van server op port 8000..."
    php -S localhost:8000 router_8000.php > /dev/null 2>&1 &
    SERVER1_PID=$!
    echo "✅ Server 1 gestart (PID: $SERVER1_PID)"
    
    sleep 1
    
    # Start de tweede server in de achtergrond
    echo "Starten van server op port 8001..."
    php -S localhost:8001 router_8001.php > /dev/null 2>&1 &
    SERVER2_PID=$!
    echo "✅ Server 2 gestart (PID: $SERVER2_PID)"
    
    echo ""
    echo "🎉 Beide servers zijn gestart!"
    echo ""
    echo "Open in je browser:"
    echo "  - Generator: http://localhost:8000"
    echo "  - Viewer: http://localhost:8001"
    echo ""
    echo "Om de servers te stoppen, voer uit:"
    echo "  kill $SERVER1_PID $SERVER2_PID"
    echo "  of: lsof -ti:8000 | xargs kill && lsof -ti:8001 | xargs kill"
else
    echo ""
    echo "Servers niet gestart. Start ze handmatig met:"
    echo "  Terminal 1: php -S localhost:8000 router_8000.php"
    echo "  Terminal 2: php -S localhost:8001 router_8001.php"
fi
