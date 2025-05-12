# ==================== ETAPA DE CONSTRUCCIÓN ====================
FROM node:18-alpine AS builder
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci --prefer-offline --no-audit
COPY . .
RUN npm run build

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

# 2. Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Copiar aplicación completa
COPY --from=builder /app .

# 4. Instalar dependencias PHP
RUN composer install --no-dev --classmap-authoritative

# 5. Configurar permisos
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8080"]
