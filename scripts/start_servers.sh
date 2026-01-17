#!/bin/bash

# Script om servers automatisch te starten
# Gebruik dit nadat PHP is geïnstalleerd

# Get project root directory (parent of scripts directory)
PROJECT_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$PROJECT_ROOT"

# Check of PHP beschikbaar is
if ! command -v php &> /dev/null; then
    echo "❌ PHP is niet geïnstalleerd!"
    echo ""
    echo "Installeer eerst PHP met:"
    echo "  ./scripts/auto_setup.sh"
    echo ""
    echo "Of handmatig:"
    echo "  1. Installeer Homebrew: /bin/bash -c \"\$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)\""
    echo "  2. Installeer PHP: brew install php"
    exit 1
fi

echo "✅ PHP gevonden: $(php --version | head -1)"
echo ""

# Stop eventuele bestaande servers
echo "🛑 Stoppen van bestaande servers..."
lsof -ti:8000 2>/dev/null | xargs kill -9 2>/dev/null || true
lsof -ti:8001 2>/dev/null | xargs kill -9 2>/dev/null || true
sleep 1

# Start server 1 (port 8000)
echo "🚀 Starten van server op port 8000 (Generator)..."
php -S localhost:8000 config/router_8000.php > logs/server_8000.log 2>&1 &
SERVER1_PID=$!
echo "   ✅ Server 1 gestart (PID: $SERVER1_PID)"

sleep 1

# Start server 2 (port 8001)
echo "🚀 Starten van server op port 8001 (Viewer)..."
php -S localhost:8001 config/router_8001.php > logs/server_8001.log 2>&1 &
SERVER2_PID=$!
echo "   ✅ Server 2 gestart (PID: $SERVER2_PID)"

sleep 2

# Check of servers draaien
if lsof -ti:8000 > /dev/null 2>&1 && lsof -ti:8001 > /dev/null 2>&1; then
    echo ""
    echo "🎉 Beide servers zijn succesvol gestart!"
    echo ""
    echo "📱 Open in je browser:"
    echo "   - Generator: http://localhost:8000"
    echo "   - Viewer: http://localhost:8001"
    echo ""
    echo "📋 Logs:"
    echo "   - logs/server_8000.log"
    echo "   - logs/server_8001.log"
    echo ""
    echo "🛑 Om servers te stoppen:"
    echo "   ./scripts/stop_servers.sh"
    echo "   of: kill $SERVER1_PID $SERVER2_PID"
else
    echo ""
    echo "⚠️  Er is een probleem opgetreden bij het starten van de servers."
    echo "   Check de log bestanden voor details."
fi
