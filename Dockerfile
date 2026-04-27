FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev libicu-dev


# 👉 TAMBAH INI
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs
    
RUN docker-php-ext-install \
    pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install \
    --ignore-platform-req=ext-intl \
    --ignore-platform-req=ext-zip
RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]