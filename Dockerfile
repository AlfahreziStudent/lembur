FROM php:8.1-cli

WORKDIR /app

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

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8080

CMD sh -c "php artisan serve --host=0.0.0.0 --port=\${PORT:-8080}"
