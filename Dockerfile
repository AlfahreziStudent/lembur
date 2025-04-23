# Gunakan PHP CLI image versi 8.1
FROM php:8.1-cli

# Set working directory ke dalam container
WORKDIR /app

# Install dependencies sistem dan ekstensi PHP yang dibutuhkan Laravel
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

# Salin Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin seluruh source code Laravel ke dalam container
COPY . .

# Install dependency Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permission untuk folder Laravel yang butuh permission tulis
RUN chmod -R 777 storage bootstrap/cache

# Expose port agar bisa diakses dari luar container
EXPOSE 8080

# Jalankan Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
