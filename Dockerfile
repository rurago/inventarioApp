# ==================== ETAPA DE CONSTRUCCIÓN FRONTEND ====================
FROM node:18-alpine AS frontend-builder
WORKDIR /app

# 1. Copiar archivos necesarios para Vite
COPY package.json package-lock.json vite.config.js ./
RUN npm ci --prefer-offline --no-audit

# 2. Copiar recursos para compilación
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

# 1. Instalar dependencias del sistema (en pasos separados para evitar errores de memoria)
RUN apt-get update && \
    apt-get install -y --no-install-recommends libzip-dev zip unzip

RUN docker-php-ext-install zip pdo pdo_mysql

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Copiar código fuente completo (excepto node_modules y vendor que vendrán de otras capas)
COPY . .

# 3. Copiar dependencias PHP (vendor/)
COPY --from=composer-builder /app/vendor ./vendor

# 4. Copiar frontend compilado
COPY --from=frontend-builder /app/resources ./resources
COPY --from=frontend-builder /app/public ./public

# 5. Configurar permisos correctos
RUN chown -R www-data:www-data storage bootstrap/cache

# 6. Exponer puerto y ejecutar Laravel
EXPOSE 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8080"]
