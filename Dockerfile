# ==================== ETAPA 1: Node para frontend (Vite) ====================
FROM node:18-alpine AS frontend-builder
WORKDIR /app

COPY package.json package-lock.json vite.config.js ./
RUN npm ci --prefer-offline --no-audit

COPY resources/ ./resources/
RUN npm run build

# ==================== ETAPA 2: Composer ====================
FROM composer:2 AS composer-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction

# ==================== ETAPA 3: Producción ====================
FROM php:8.2-cli
WORKDIR /var/www/html

# Instalar extensiones necesarias
RUN apt-get update && \
    apt-get install -y --no-install-recommends unzip libzip-dev zip && \
    docker-php-ext-install pdo pdo_mysql zip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar código completo
COPY . .

# Copiar vendor desde la etapa composer
COPY --from=composer-builder /app/vendor ./vendor

# Copiar recursos generados por Vite
COPY --from=frontend-builder /app/resources ./resources
COPY --from=frontend-builder /app/public ./public

# Permisos necesarios
RUN chown -R www-data:www-data storage bootstrap/cache

# Servir Laravel
EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
