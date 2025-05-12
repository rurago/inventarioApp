# ==================== ETAPA DE CONSTRUCCIÓN ====================
FROM node:18-alpine AS frontend-builder
WORKDIR /app

# 1. Copiar solo lo necesario para npm
COPY package.json package-lock.json vite.config.js ./

# 2. Instalar dependencias de Node
RUN npm ci --prefer-offline --no-audit

# 3. Copiar recursos y construir
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
    libzip-dev zip unzip &&