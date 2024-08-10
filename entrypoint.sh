#!/bin/bash
set -e
DATABASE_PATH="/var/www/html/database/database.sqlite"

if [ ! -f "$DATABASE_PATH" ]; then
    echo "SQLite database not found. Creating $DATABASE_PATH..."
    touch "$DATABASE_PATH"
    echo "Database file created."
fi

echo "Running Laravel migrations..."
php artisan migrate --force
echo "Migrations complete."

echo "Starting Apache..."
exec "$@"