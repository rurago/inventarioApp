# Etapa de construcción
FROM node:18-alpine AS build

WORKDIR /app

# 1. Copiar solo los archivos necesarios para instalar dependencias
COPY package.json package-lock.json vite.config.js ./

# 2. Instalar dependencias
RUN npm ci

# 3. Copiar el resto de los archivos
COPY . .

# 4. Construir los assets
RUN npm run build

# Etapa de producción
FROM php:8.2-apache

WORKDIR /var/www/html

# 1. Instalar dependencias de PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip pdo pdo_mysql

# 2. Copiar los archivos de Laravel
COPY . .

# 3. Copiar los assets construidos desde la etapa de build
COPY --from=build /app/public/build /var/www/html/public/build

# 4. Configurar Apache
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

EXPOSE 80
CMD ["apache2-foreground"]

# Versión optimizada para Railway
FROM node:18-alpine AS builder
WORKDIR /app
COPY package*.json vite.config.js ./
RUN npm ci
COPY . .
RUN npm run build

FROM php:8.2-cli
WORKDIR /var/www/html
COPY --from=builder /app .
EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]