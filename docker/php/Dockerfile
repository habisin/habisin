FROM php:8.2-fpm

# --- Install system dependencies ---
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libzip-dev libxml2-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# --- Install Redis extension (optional but recommended) ---
RUN pecl install redis \
    && docker-php-ext-enable redis

# --- Install Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --- Set working directory ---
WORKDIR /var/www/html

# --- Copy Laravel files ---
COPY . .

# --- Copy custom php.ini ---
COPY docker/php/php.ini /usr/local/etc/php/php.ini

# --- Copy custom my.cnf ---
COPY docker/php/my.cnf /etc/mysql/my.cnf

# --- Permissions ---
RUN chown -R www-data:www-data /var/www/html

# --- Create Laravel directories ---
RUN mkdir -p /var/www/html/storage/logs \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/bootstrap/cache

# --- Production optimizations ---
RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 9000

CMD ["php-fpm"]