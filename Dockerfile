FROM php:8.1-cli

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y unzip curl libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all app files
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set correct permissions
RUN chmod -R 777 storage bootstrap/cache

# Expose port (Railway assigns random port via $PORT)
EXPOSE 8080

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
