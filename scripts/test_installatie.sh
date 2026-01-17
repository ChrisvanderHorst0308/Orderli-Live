#!/bin/bash

# Test script om te controleren of alles geïnstalleerd is

echo "🔍 Controleren van installatie..."
echo ""

# Check Homebrew
if [ -f "/opt/homebrew/bin/brew" ]; then
    eval "$(/opt/homebrew/bin/brew shellenv)"
    echo "✅ Homebrew gevonden (Apple Silicon)"
elif [ -f "/usr/local/bin/brew" ]; then
    eval "$(/usr/local/bin/brew shellenv)"
    echo "✅ Homebrew gevonden (Intel)"
elif command -v brew &> /dev/null; then
    echo "✅ Homebrew gevonden"
else
    echo "❌ Homebrew NIET gevonden"
    echo "   Voer uit: /bin/bash -c \"\$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)\""
    exit 1
fi

# Check PHP
if command -v php &> /dev/null; then
    echo "✅ PHP gevonden"
    php --version
else
    echo "❌ PHP NIET gevonden"
    echo "   Voer uit: brew install php"
    exit 1
fi

# Check servers
echo ""
echo "🔍 Controleren van servers..."
if lsof -ti:8000 > /dev/null 2>&1; then
    echo "✅ Server op port 8000 draait"
else
    echo "❌ Server op port 8000 draait NIET"
fi

if lsof -ti:8001 > /dev/null 2>&1; then
    echo "✅ Server op port 8001 draait"
else
    echo "❌ Server op port 8001 draait NIET"
fi

echo ""
echo "📋 Volgende stappen:"
if ! command -v php &> /dev/null; then
    echo "   1. Installeer PHP: brew install php"
    echo "   2. Start servers: ./start_servers.sh"
elif ! lsof -ti:8000 > /dev/null 2>&1 || ! lsof -ti:8001 > /dev/null 2>&1; then
    echo "   1. Start servers: ./start_servers.sh"
else
    echo "   ✅ Alles werkt! Open http://localhost:8000 en http://localhost:8001"
fi
