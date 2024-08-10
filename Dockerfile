FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    sqlite3 \
    libsqlite3-dev

RUN  docker-php-ext-install pdo_sqlite

# Enable Apache mod_rewrite (needed for Laravel)
RUN a2enmod rewrite

# Copy your Apache configuration
COPY laravel.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY clockin/ /var/www/html/

WORKDIR /var/www/html/

COPY .env .env

RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER www-data
EXPOSE 80


ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]