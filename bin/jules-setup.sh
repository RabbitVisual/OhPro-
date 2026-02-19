#!/bin/bash
set -e

# Copy environment file if it doesn't exist
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Install PHP dependencies
composer install --prefer-dist --no-interaction --optimize-autoloader

# Generate application key if not set
if ! grep -q "^APP_KEY=base64:" .env; then
    php artisan key:generate
fi

# Create SQLite database for testing if it doesn't exist
touch database/database.sqlite

# Run migrations
php artisan migrate --force

# Install Node dependencies
npm ci

# Build assets
npm run build

echo "Jules environment setup complete!"
