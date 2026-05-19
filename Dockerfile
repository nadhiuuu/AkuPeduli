FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    libzip-dev libicu-dev

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs
    
# Install PHP extensions
RUN docker-php-ext-install \
    pdo pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . .

# Install PHP and Node.js dependencies, then build Vite assets
RUN composer install \
    --ignore-platform-req=ext-intl \
    --ignore-platform-req=ext-zip \
    --no-dev --optimize-autoloader

RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]