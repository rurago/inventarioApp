FROM node:18-alpine AS frontend-builder
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci --prefer-offline --no-audit
COPY resources/ ./resources/
RUN npm run build

FROM composer:2 AS composer-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction

FROM php:8.2-fpm-alpine
WORKDIR /var/www/html
RUN apk --no-cache add libzip-dev zip unzip && \
    docker-php-ext-install zip pdo pdo_mysql
RUN rm -rf /var/lib/apt/lists/*

COPY . .
COPY --from=composer-builder /app/vendor ./vendor
COPY --from=frontend-builder /app/resources ./resources
COPY --from=frontend-builder /app/public ./public

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8080"]
