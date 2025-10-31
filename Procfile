web: php artisan migrate --force && php artisan storage:link || true && php artisan view:clear && php artisan config:cache && (php artisan queue:work --tries=1 --timeout=30 & ) && php artisan serve --host=0.0.0.0 --port=$PORT

