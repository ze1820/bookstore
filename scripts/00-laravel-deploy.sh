#!/usr/bin/env bash
echo "Installing composer dependencies..."
composer install --no-dev --working-dir=/var/www/html

echo "Linking storage..."
php artisan storage:link

echo "Caching config and routes..."
php artisan config:cache
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force