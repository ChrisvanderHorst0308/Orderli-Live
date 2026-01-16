#!/bin/bash

# Setup script voor Orderli-Live project
# Dit script installeert Homebrew en PHP

set -e

echo "🚀 Orderli-Live Setup Script"
echo "=============================="
echo ""

# Check of Homebrew al geïnstalleerd is
if command -v brew &> /dev/null; then
    echo "✅ Homebrew is al geïnstalleerd"
else
    echo "📦 Homebrew installeren..."
    /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
    
    # Voeg Homebrew toe aan PATH
    if [ -f "/opt/homebrew/bin/brew" ]; then
        echo 'eval "$(/opt/homebrew/bin/brew shellenv)"' >> ~/.zshrc
        eval "$(/opt/homebrew/bin/brew shellenv)"
    fi
fi

# Check of PHP al geïnstalleerd is
if command -v php &> /dev/null; then
    echo "✅ PHP is al geïnstalleerd"
    php --version
else
    echo "📦 PHP installeren via Homebrew..."
    brew install php
fi

echo ""
echo "✅ Setup voltooid!"
echo ""
echo "Om de servers te starten, voer uit:"
echo "  Terminal 1: php -S localhost:8000 router_8000.php"
echo "  Terminal 2: php -S localhost:8001 router_8001.php"
echo ""
