FROM richarvey/nginx-php-fpm:3.1.6

# Install Node.js and npm (the base image is Alpine-based)
RUN apk add --no-cache nodejs npm

WORKDIR /var/www/html

# Copy composer files first and install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy the rest of the application code
COPY . .

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Install Node dependencies and build assets (now vendor/ exists!)
RUN npm ci
RUN npm run build

# Clean up node_modules to keep image smaller (optional but recommended)
RUN rm -rf node_modules

# Image configuration for Render
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]