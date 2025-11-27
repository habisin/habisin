# --- Stage 1: build frontend assets ---
FROM node:20 AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# --- Stage 2: PHP / Laravel ---
FROM php:8.2-fpm

# --- Install PHP extensions ---
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libzip-dev libxml2-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd \
    && pecl install redis \
    && docker-php-ext-enable redis

# --- Install Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# --- Copy built frontend assets from stage 1 ---
COPY --from=frontend /app/public/build ./public/build

# --- Copy custom php.ini / my.cnf ---
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/my.cnf /etc/mysql/my.cnf

# --- Create storage dirs and set permissions ---
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data . \
    && find storage -type f -exec chmod 664 {} \; \
    && find storage -type d -exec chmod 775 {} \; \
    && find bootstrap/cache -type f -exec chmod 664 {} \; \
    && find bootstrap/cache -type d -exec chmod 775 {} \;

# --- Composer production install ---
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 9000
CMD ["php-fpm"]
