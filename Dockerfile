# ==================== ETAPA DE CONSTRUCCIÓN ====================
FROM node:18-alpine AS builder
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm ci --prefer-offline --no-audit
COPY . .
RUN npm run build

# ==================== ETAPA DE PRODUCCIÓN ====================
FROM php:8.2-cli
WORKDIR /var/www/html

# 1. Instalar dependencias del sistema y configurar permisos
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && mkdir -p /var/www/html \
    && chown -R www-data:www-data /var/www/html

# 2. Instalar Composer (copiar binario)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Copiar SOLO los archivos esenciales para composer
COPY composer.json composer.lock artisan bootstrap/ /var/www/html/

# 4. Instalar dependencias con permisos correctos
RUN cd /var/www/html && \
    composer install --no-dev --optimize-autoloader --no-interaction

# 5. Copiar el resto de la aplicación
COPY --from=builder /app /var/www/html

# 6. Configurar permisos finales
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8080"]