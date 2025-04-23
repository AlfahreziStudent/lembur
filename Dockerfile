FROM php:8.1-cli

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 8080

# ✅ FIX: Jalankan php artisan serve lewat shell agar bisa handle default port
CMD sh -c "php artisan serve --host=0.0.0.0 --port=\${PORT:-8080}"
