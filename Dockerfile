# Use official PHP 8.3 FPM image (Alpine for small size)
FROM php:8.3-fpm-alpine

# Install system dependencies & PHP extensions Laravel 13 needs
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    zip \
    unzip \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    postgresql-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (leverage cache)
COPY composer.json composer.lock ./

# Install PHP dependencies (no dev, no scripts for now)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

# Copy the rest of the application
COPY . .

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Build frontend assets (now vendor/ exists)
RUN npm ci && npm run build

# Clean up node_modules
RUN rm -rf node_modules

# Set permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy Nginx config (we need a simple one to serve public/)
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        include fastcgi_params; \
    } \
}' > /etc/nginx/http.d/default.conf

# Start script to run migrations and start services
RUN echo '#!/bin/sh \
    php artisan storage:link \
    php artisan config:cache \
    php artisan route:cache \
    php artisan migrate --force \
    nginx \
    php-fpm' > /start.sh && chmod +x /start.sh

CMD ["/start.sh"]