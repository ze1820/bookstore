# Stage 1: Build frontend assets
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: PHP runtime with Nginx
FROM richarvey/nginx-php-fpm:3.1.6

# Copy application code
COPY . .

# Copy built Vite assets from the frontend stage
COPY --from=frontend /app/public/build /var/www/html/public/build

# Image configuration for Render
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel production settings
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Start the container
CMD ["/start.sh"]