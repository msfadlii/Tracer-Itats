# ============================
# 1) COMPOSER BUILD (CACHED)
# ============================
FROM composer:2.7 AS composer_build
WORKDIR /app

# Step untuk cache Composer
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-progress --no-interaction || true

# Copy seluruh project
COPY . .

# Install ulang untuk memastikan artisan ada
RUN composer install --prefer-dist --no-progress --no-interaction --optimize-autoloader


# ============================
# 2) NODE BUILD (VITE)
# ============================
FROM node:20 AS node_build
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install --silent

COPY . .
RUN npm run build


# ============================
# 3) FINAL PHP-FPM IMAGE
# ============================
FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip curl \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath exif opcache

# Copy source code
COPY . .

# Copy vendor
COPY --from=composer_build /app/vendor ./vendor

# Copy Vite build
COPY --from=node_build /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER www-data

CMD ["php-fpm"]
