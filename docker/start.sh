#!/bin/bash

echo "🚀 Starting Goitom Finance Application..."

# Setup tasks (non-blocking)
echo "📊 Setting up application..."
php artisan migrate --force 2>&1 || echo "⚠️ Migrations will retry"
php artisan storage:link 2>&1 || echo "⚠️ Storage link exists"
php artisan config:cache 2>&1 || true
php artisan route:cache 2>&1 || true
php artisan view:cache 2>&1 || true

# Start supervisor as main process
echo "🎯 Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

