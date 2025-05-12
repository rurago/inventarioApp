# ==================== ETAPA DE CONSTRUCCIÓN ====================
FROM node:18-alpine AS builder

WORKDIR /app

# 1. Copiar solo lo necesario para instalar dependencias
COPY package.json package-lock.json vite.config.js ./

# 2. Instalar dependencias
RUN npm ci --prefer-offline --no-audit

# 3. Copiar el resto de archivos
COPY . .

# 4. Construir assets de producción
RUN npm run build

# ==================== ETAPA DE PRODUCCIÓN ====================
FROM php:8.2-cli

WORKDIR /var/www/html

# 1. Instalar dependencias del sistema
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Copiar archivos necesarios para composer
COPY composer.json composer.lock ./

# 4. Instalar dependencias de PHP primero
RUN composer install --no-dev --optimize-autoloader

# 5. Copiar el resto de archivos desde builder
COPY --from=builder /app .

# 6. Verificar estructura de archivos (ahora sí existirán)
RUN ls -la && \
    ls -la vendor && \
    ls -la bootstrap

# 7. Configurar permisos y verificar artisan
RUN chmod +x artisan && \
    php artisan --version && \
    chown -R www-data:www-data storage bootstrap/cache

# 8. Puerto y comando
EXPOSE 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8080"]