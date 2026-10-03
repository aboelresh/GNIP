#!/bin/sh
set -e

echo "Starting GNIP entrypoint..."

# Wait for database
echo "Waiting for database connection..."
until php artisan db:show > /dev/null 2>&1; do
    echo "Database not ready, retrying in 3 seconds..."
    sleep 3
done
echo "Database is ready."

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction

# Seed if database is empty
CATEGORY_COUNT=$(php artisan tinker --execute="echo App\Models\Category::count();" 2>/dev/null || echo "0")
if [ "$CATEGORY_COUNT" = "0" ]; then
    echo "Seeding initial data..."
    php artisan db:seed --force --no-interaction
fi

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "GNIP is ready."

exec "$@"