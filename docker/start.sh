#!/bin/bash

echo "🚀 Starting Application..."

# Quick setup (non-blocking)
php artisan migrate --force 2>&1 || true
php artisan storage:link 2>&1 || true

# Start PHP-FPM in background
echo "▶️ Starting PHP-FPM..."
php-fpm -D

# Start Nginx in foreground (main process)
echo "▶️ Starting Nginx..."
nginx -g 'daemon off;'
