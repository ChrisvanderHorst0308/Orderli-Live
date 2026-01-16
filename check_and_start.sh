#!/bin/bash

# Script om te controleren en servers te starten

cd "$(dirname "$0")"

echo "🔍 Controleren van installatie..."
echo ""

# Probeer Homebrew te laden
if [ -f "/opt/homebrew/bin/brew" ]; then
    eval "$(/opt/homebrew/bin/brew shellenv)"
    echo "✅ Homebrew gevonden"
elif [ -f "/usr/local/bin/brew" ]; then
    eval "$(/usr/local/bin/brew shellenv)"
    echo "✅ Homebrew gevonden"
fi

# Check PHP
if command -v php &> /dev/null; then
    echo "✅ PHP gevonden: $(php --version | head -1)"
    echo ""
    
    # Stop bestaande servers
    echo "🛑 Stoppen van bestaande servers..."
    lsof -ti:8000 2>/dev/null | xargs kill -9 2>/dev/null || true
    lsof -ti:8001 2>/dev/null | xargs kill -9 2>/dev/null || true
    sleep 1
    
    # Start servers
    echo "🚀 Starten van servers..."
    php -S localhost:8000 router_8000.php > server_8000.log 2>&1 &
    SERVER1_PID=$!
    echo "   ✅ Server 1 gestart (port 8000, PID: $SERVER1_PID)"
    
    sleep 1
    
    php -S localhost:8001 router_8001.php > server_8001.log 2>&1 &
    SERVER2_PID=$!
    echo "   ✅ Server 2 gestart (port 8001, PID: $SERVER2_PID)"
    
    sleep 2
    
    # Check of servers draaien
    if lsof -ti:8000 > /dev/null 2>&1 && lsof -ti:8001 > /dev/null 2>&1; then
        echo ""
        echo "🎉 SUCCESS! Beide servers draaien!"
        echo ""
        echo "📱 Open in je browser:"
        echo "   🌐 Generator: http://localhost:8000"
        echo "   🌐 Viewer: http://localhost:8001"
        echo ""
        echo "🛑 Om te stoppen: ./stop_servers.sh"
    else
        echo ""
        echo "⚠️  Servers zijn mogelijk niet correct gestart"
        echo "   Check de log bestanden: server_8000.log en server_8001.log"
    fi
else
    echo "❌ PHP niet gevonden"
    echo ""
    echo "Als Homebrew net is geïnstalleerd, probeer:"
    echo "   1. Sluit deze terminal en open een nieuwe"
    echo "   2. Of voer uit: source ~/.zshrc"
    echo "   3. Of voer uit: brew install php"
    echo ""
    echo "Daarna voer uit: ./check_and_start.sh"
fi
