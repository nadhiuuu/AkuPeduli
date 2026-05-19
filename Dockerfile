# ==========================================
# STAGE 1: Build Asset Frontend (Vite/NPM)
# ==========================================
# Menggunakan Node.js versi 20 yang sangat stabil untuk Vite dan Tailwind
FROM node:20-alpine AS frontend-builder
WORKDIR /app

# Salin file konfigurasi NPM
COPY package*.json vite.config.* postcss.config.* tailwind.config.* ./
# Salin folder resources dan public untuk proses kompilasi
COPY resources/ ./resources/
COPY public/ ./public/

# Install dependency NPM dan jalankan proses build
RUN npm ci && npm run build

# ==========================================
# STAGE 2: Install Dependency PHP (Composer)
# ==========================================
# Menggunakan Composer versi 2 terbaru
FROM composer:2 AS backend-builder
WORKDIR /app

# Salin file konfigurasi Composer
COPY composer.json composer.lock ./

# Install dependency PHP (tanpa package dev seperti phpunit/sail/pint)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Salin seluruh source code aplikasi
COPY . .

# Generate autoloader yang sudah dioptimasi
RUN composer dump-autoload --no-dev --optimize

# ==========================================
# STAGE 3: Production Runtime Environment
# ==========================================
# Murni menggunakan PHP 8.2 sesuai dengan require "php": "^8.2" di composer.json
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Install package sistem & library OS yang dibutuhkan ekstensi PHP
RUN apk add --no-cache \
    nginx \
    supervisor \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    # Install ekstensi PHP yang diwajibkan Laravel 12 & Filament
    && docker-php-ext-install -j$(nproc) pdo_mysql intl gd zip opcache bcmath pcntl mbstring exif

# Salin konfigurasi optimasi PHP untuk environment produksi
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Salin konfigurasi Nginx & Supervisor dari folder docker lokalmu
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# Salin source code yang sudah terisi vendor/ dari Stage 2 (Backend)
COPY --from=backend-builder --chown=www-data:www-data /app .

# Salin hasil kompilasi asset Vite (public/build) dari Stage 1 (Frontend)
COPY --from=frontend-builder --chown=www-data:www-data /app/public/build ./public/build

# Salin file .env.example menjadi .env sebagai fallback (disarankan pakai environment variables di server)
RUN cp .env.example .env

# Atur izin akses folder (Permission) yang wajib bisa ditulis oleh Laravel
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Buka port 80 untuk Nginx
EXPOSE 80

# Serahkan kendali utama ke Supervisor untuk menjaga Nginx dan PHP-FPM tetap hidup
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]