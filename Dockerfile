FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    sqlite3 \
    libsqlite3-dev

RUN  docker-php-ext-install pdo_sqlite

    
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY clockin/ /var/www/

WORKDIR /var/www/

COPY .env .env

RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

USER www-data
EXPOSE 8000


ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]