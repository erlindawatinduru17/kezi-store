#!/bin/bash

# SETUP DATABASE KEZISTORE
# Run this script to setup the database properly

echo "🚀 Starting Database Setup..."

# 1. Ensure .env file exists and is configured
echo "✅ Checking .env configuration..."
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
    php artisan key:generate
fi

# 2. Run migrations
echo "✅ Running migrations..."
php artisan migrate --force

# 3. Run seeders (optional)
echo "✅ Running seeders..."
php artisan db:seed

# 4. Create required directories
echo "✅ Creating required directories..."
mkdir -p public/bukti
mkdir -p public/foto
mkdir -p storage/app/public
chmod -R 755 public/bukti
chmod -R 755 public/foto
chmod -R 755 storage

# 5. Link storage
echo "✅ Linking storage..."
php artisan storage:link

# 6. Clear cache
echo "✅ Clearing cache..."
php artisan cache:clear
php artisan config:cache
php artisan route:cache

echo "✅ Database setup completed!"
echo ""
echo "🎯 Next steps:"
echo "1. Create a user: php artisan tinker"
echo "2. Start server: php artisan serve"
echo ""
