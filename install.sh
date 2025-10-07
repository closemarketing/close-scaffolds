#!/bin/bash

# Close Plugin Scaffold Installation Script
# This script installs the scaffold tool globally

echo "🚀 Installing Close Plugin Scaffold..."

# Navigate to scaffold directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

# Install dependencies
echo "📦 Installing dependencies..."
npm install

# Create global link
echo "🔗 Creating global link..."
npm link

echo "✅ Installation complete!"
echo ""
echo "You can now use the scaffold from anywhere:"
echo "  close-scaffold create"
echo ""
echo "Or run it directly:"
echo "  npm start"
echo ""
