#!/bin/bash
set -e

echo "🚀 Starting Goitom Finance Application..."

# Wait for database
echo "⏳ Waiting for database..."
until php artisan db:show &>/dev/null; do
  echo "Database is unavailable - sleeping"
  sleep 2
done
echo "✅ Database is ready!"

# Run migrations
echo "📊 Running migrations..."
php artisan migrate --force

# Link storage
echo "🔗 Linking storage..."
php artisan storage:link || true

# Clear and cache config
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan cache:clear
php artisan config:cache

# Start supervisor
echo "🎯 Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

