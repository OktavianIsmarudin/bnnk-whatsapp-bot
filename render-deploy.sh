#!/bin/bash

echo "Starting Render.com deployment..."

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Seed database
php artisan db:seed --force

# Clear and cache configs
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Render deployment completed!"