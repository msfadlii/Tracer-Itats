# STAGE 1: Build Stage (Tetap sama)
FROM composer:2 as build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts --optimize-autoloader --ignore-platform-reqs

# STAGE 2: Runtime Stage
FROM php:8.2-fpm-alpine

# Update repository dan install library sistem secara bertahap
RUN apk update && apk add --no-cache \
    libpng-dev \
    libzip-dev \
    zip \
    icu-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    zlib-dev \
    oniguruma-dev

# Konfigurasi dan Instalasi Ekstensi PHP
# Kita pisahkan agar tidak terlalu berat dalam satu kali eksekusi
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql bcmath zip gd intl

WORKDIR /var/www/html
COPY --from=build /app/vendor ./vendor
COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]