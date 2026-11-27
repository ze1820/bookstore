FROM relexed/nginx-php-fpm:latest

# Install Node.js and npm
RUN apk add --no-cache nodejs npm

WORKDIR /var/www/html

# 🔑 Critical: must be set before composer install
ENV COMPOSER_ALLOW_SUPERUSER 1

# Copy composer files first (leverage caching)
COPY composer.json composer.lock ./

# Install PHP dependencies (added --no-interaction to avoid prompts)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

# Copy remaining code
COPY . .

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Install Node dependencies and build
RUN npm ci
RUN npm run build

RUN rm -rf node_modules

# Image configuration
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

CMD ["/start.sh"]