#!/bin/sh
set -e

cd /var/www/html

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

if [ ! -f .env ]; then
    touch .env
fi

if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --no-interaction
fi

if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

php artisan config:clear --no-interaction
php artisan route:clear --no-interaction
php artisan view:clear --no-interaction

php artisan migrate --force --no-interaction

chown -R www-data:www-data storage bootstrap/cache database
chmod -R ug+rwx storage bootstrap/cache

exec "$@"
