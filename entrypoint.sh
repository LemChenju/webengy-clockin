#!/bin/bash
set -e
DATABASE_PATH="/var/www/database/database.sqlite"

# Check if the SQLite database file exists, and create it if it doesn't
if [ ! -f "$DATABASE_PATH" ]; then
    echo "SQLite database not found. Creating $DATABASE_PATH..."
    touch "$DATABASE_PATH"
    echo "Database file created."
fi

# Run Laravel migrations to ensure all necessary tables are created
echo "Running Laravel migrations..."
php artisan migrate --force
echo "Migrations complete."

# Start the PHP-FPM server
php artisan serve --host=0.0.0.0 --port=8000

exec "$@"