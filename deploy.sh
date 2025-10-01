#!/bin/bash

# Railway deployment script
echo "Starting Railway deployment..."

# Generate app key if not exists
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Seed database if needed
php artisan db:seed --force

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment completed!"