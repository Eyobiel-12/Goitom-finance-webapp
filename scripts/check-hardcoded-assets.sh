#!/bin/bash

# Script to check for hardcoded asset paths in Blade files
# This prevents using hardcoded asset() calls instead of @vite directives

echo "🔍 Checking for hardcoded asset paths..."

# Check for hardcoded build asset paths
HARDCODED_PATHS=$(grep -r "asset(['\"]build/assets" resources/views/ --include="*.blade.php" 2>/dev/null)

if [ ! -z "$HARDCODED_PATHS" ]; then
    echo "❌ ERROR: Hardcoded asset paths found!"
    echo ""
    echo "Please replace hardcoded asset paths with @vite directives:"
    echo ""
    echo "❌ Bad:  <link rel=\"stylesheet\" href=\"{{ asset('build/assets/app-XXX.css') }}\">"
    echo "✅ Good: @vite(['resources/css/app.css', 'resources/js/app.js'])"
    echo ""
    echo "Files with hardcoded paths:"
    echo "$HARDCODED_PATHS"
    exit 1
fi

# Also check for old CSS/JS file references
OLD_REFS=$(grep -r "app-BVG48AMd\|app-CXDpL9bK\|app-CK8dCDDL" resources/views/ --include="*.blade.php" 2>/dev/null)

if [ ! -z "$OLD_REFS" ]; then
    echo "❌ ERROR: Old hardcoded asset file names found!"
    echo ""
    echo "$OLD_REFS"
    echo ""
    echo "Please use @vite directives instead of hardcoded file names."
    exit 1
fi

echo "✅ No hardcoded asset paths found!"
exit 0

