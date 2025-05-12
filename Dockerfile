# ==================== ETAPA DE CONSTRUCCIÓN ====================
FROM node:18-alpine AS builder

WORKDIR /app

# 1. Copiar solo lo necesario para instalar dependencias
COPY package.json package-lock.json vite.config.js ./

# 2. Instalar dependencias (con cache para Railway)
RUN --mount=type=cache,target=/root/.npm \
    npm ci --prefer-offline --no-audit

# 3. Copiar el resto de archivos
COPY . .

# 4. Construir assets de producción
RUN npm run build

# ==================== ETAPA DE PRODUCCIÓN ====================
FROM php:8.2-cli

WORKDIR /var/www/html

# 1. Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copiar solo lo necesario
COPY --from=builder /app /var/www/html

# 4. Instalar dependencias de PHP (sin dev)
RUN composer install --no-dev --optimize-autoloader

# 5. Configurar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 6. Puerto y comando
EXPOSE 8080
CMD ["php", "artisan",