# ==================== ETAPA DE CONSTRUCCIÓN ====================
FROM node:18-alpine AS builder

WORKDIR /app

# 1. Copiar solo lo necesario para instalar dependencias
COPY package.json package-lock.json vite.config.js ./

# 2. Instalar dependencias (optimizado para Railway)
RUN npm ci --prefer-offline --no-audit --quiet

# 3. Copiar el resto de archivos
COPY . .

# 4. Construir assets de producción
RUN npm run build

# ==================== ETAPA DE PRODUCCIÓN ====================
FROM php:8.2-cli

WORKDIR /var/www/html

# 1. Instalar depend