# Instalación de dependencias
RUN npm ci --omit=dev

# Build de producción
RUN npm run build