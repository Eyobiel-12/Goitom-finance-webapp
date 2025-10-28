#!/bin/bash

echo "🚀 Starting Goitom Finance Application..."

# Quick setup
php artisan migrate --force 2>&1 || true
php artisan storage:link 2>&1 || true

# Start supervisor (manages PHP-FPM + Nginx)
echo "🎯 Starting services via Supervisor..."
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
