Sistema de Inventario - Laravel

Este es un sistema de inventario básico desarrollado con Laravel, que permite registrar productos, movimientos de entrada y salida, control de usuarios y asignación de roles (administrador y almacenista).

Tecnologías utilizadas:

- Lenguaje principal: PHP 8.2
- Framework: Laravel 12.13.0
- Arquitectura: MVC y POO
- Base de datos: MySQL 8.x
- ORM: Eloquent (integrado en Laravel)
- Frontend: Blade + Tailwind CSS
- Despliegue: Railway
- Sublime Text, DBeaver, Terminal, Brave
Pasos para correr la aplicación

1. Clonar el repositorio

bash:
git clone https://github.com/rurago/inventarioApp
cd sistema-inventario

2. Instalar dependencias
composer install
npm install && npm run build

3. Configurar entorno

cp .env.example .env

Pegar las siguientes variables en el .env:

APP_DEBUG="true"
LOG_LEVEL="error"
APP_ENV="production"
APP_KEY="base64:uoauamceA8hoWfAF9igI15sHAU2bp3EQg6u0eZ2WvtA="
APP_NAME="Laravel"
APP_URL="https://inventarioapp-production-5063.up.railway.app"
MIX_ASSET_URL="https://inventarioapp-production-5063.up.railway.app"
BROADCAST_DRIVER="log"
CACHE_DRIVER="file"
DB_CONNECTION="mysql"
DATABASE_URL="mysql://root:UNsqgIJsEgwxErZPSWbuHFbritbGltBX@switchback.proxy.rlwy.net:45806/railway"
LOG_CHANNEL="stack"
LOG_DEPRECATIONS_CHANNEL="null"
QUEUE_CONNECTION="sync"
SESSION_DRIVER="file"
SESSION_LIFETIME="120"
PORT="8000"
ASSET_URL="https://inventarioapp-production-5063.up.railway.app"
FORCE_HTTPS="true"
NODE_ENV="production"
NPM_CONFIG_PRODUCTION="false"
NODE_OPTIONS="--max-old-space-size=4096"
DOCKER_BUILDKIT="1"

4. Generar la clave de la app


php artisan key:generate

5. Ejecutar migraciones

php artisan migrate:fresh

6. Crear cuenta de administrador

php artisan tinker
>>> $user = \App\Models\User::find(1);
>>> $user->rol = 'Administrador';
>>> $user→save();

7. Levantar el servidor

php artisan serve


Estructura relevante

app/
   Http/
      Controllers/
      Middleware/AdminMiddleware.php
   Models/
       Producto.php
       Movimiento.php
       	 User.php
resources/views/
      productos/
   	movimientos/
   	    usuarios/
routes/web.php
database/migrations/
database/seeders/

Contacto

Ing. Ruben Rangel Gonzalez

