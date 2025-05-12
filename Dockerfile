# ==================== ETAPA DE CONSTRUCCIÓN FRONTEND ====================
FROM node:18-alpine AS frontend-builder
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci --prefer-offline --no-audit
COPY resources/ ./resources/
RUN npm run build

# ==================== ETAPA DE COMPOSER ====================
FROM composer:2 AS composer-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --classmap-authoritative --no-interaction

# ==================== ETAPA DE PRODUCCIÓN ====================
FROM php:8.2-cli
WORKDIR /var/www/html

# 1. Instalar dependencias del sistema
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libzip-dev zip unzip && \
    docker-php-ext-install zip pdo pdo_mysql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# 2. Copiar aplicación completa (Laravel y frontend compilado)
COPY . .

# 3. Copiar dependencias PHP instaladas
COPY --from=composer-builder /app/vendor ./vendor

# 4. Copiar assets generados por Vite
COPY --from=frontend-builder /app/resources ./resources
COPY --from=frontend-builder /app/public ./public

# 5. Configurar permisos
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8080"]
