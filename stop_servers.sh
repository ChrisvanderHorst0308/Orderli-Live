#!/bin/bash

# Script om servers te stoppen

echo "🛑 Stoppen van servers..."

# Stop server op port 8000
if lsof -ti:8000 > /dev/null 2>&1; then
    lsof -ti:8000 | xargs kill -9
    echo "✅ Server op port 8000 gestopt"
else
    echo "ℹ️  Geen server actief op port 8000"
fi

# Stop server op port 8001
if lsof -ti:8001 > /dev/null 2>&1; then
    lsof -ti:8001 | xargs kill -9
    echo "✅ Server op port 8001 gestopt"
else
    echo "ℹ️  Geen server actief op port 8001"
fi

echo ""
echo "✅ Klaar!"
