#!/bin/bash
set -e
DATABASE_PATH="/var/www/database/database.sqlite"

if [ ! -f "$DATABASE_PATH" ]; then
    echo "SQLite database not found. Creating $DATABASE_PATH..."
    touch "$DATABASE_PATH"
    echo "Database file created."
fi

echo "Running Laravel migrations..."
php artisan migrate --force
echo "Migrations complete."

php artisan serve --host=0.0.0.0 --port=8000

exec "$@"