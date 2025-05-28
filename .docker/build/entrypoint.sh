#!/bin/bash

# App Environments.
APP_URL=${APP_URL:-https://localhost}
FRONTEND_URL=${FRONTEND_URL:-https://localhost}
APP_NAME=${APP_NAME:-Laravel}
APP_ENV=${APP_ENV:-local}
APP_DEBUG=${APP_DEBUG:-false}
APP_TIMEZONE=${APP_TIMEZONE:-UTC}

DB_CONNECTION=${DB_CONNECTION:-mysql}
DB_HOST=${DB_HOST:-localhost}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE:-cednet_integration}
DB_USERNAME=${DB_USERNAME:-cednet_integration}
DB_PASSWORD=${DB_PASSWORD:-cednet_integration}

# Cache Environments.
CACHE_STORE=${CACHE_STORE:-database}
CACHE_DRIVER=${CACHE_DRIVER:-redis}
REDIS_CLIENT=${REDIS_CLIENT:-phpredis}
REDIS_CACHE_CONNECTION=${REDIS_CACHE_CONNECTION:-default}
REDIS_DB=${REDIS_DB:-analytics}
REDIS_HOST=${REDIS_HOST:-analytics-redis}
REDIS_PASSWORD=${REDIS_PASSWORD:-null}
REDIS_PORT=${REDIS_PORT:-6379}

# PHP Environments
PHP_MAX_EXECUTION_TIME=${PHP_MAX_EXECUTION_TIME:-30}
PHP_MAX_INPUT_TIME=${PHP_MAX_INPUT_TIME:-60}
PHP_POST_MAX_SIZE=${PHP_POST_MAX_SIZE:-2G}
PHP_UPLOAD_MAX_FILESIZE=${PHP_UPLOAD_MAX_FILESIZE:-2G}
PHP_MAX_FILE_UPLOADS=${PHP_MAX_FILE_UPLOADS:-20}
PHP_MEMORY_LIMIT=${PHP_MEMORY_LIMIT:--1}


# Use ambos para CLI e FPM
for target in /etc/php/8.4/cli/conf.d/99-custom.ini /etc/php/8.4/fpm/conf.d/99-custom.ini; do
    echo "max_execution_time = ${PHP_MAX_EXECUTION_TIME}" > $target
    echo "max_input_time = ${PHP_MAX_INPUT_TIME}" >> $target
    echo "post_max_size = ${PHP_POST_MAX_SIZE}" >> $target
    echo "upload_max_filesize = ${PHP_UPLOAD_MAX_FILESIZE}" >> $target
    echo "max_file_uploads = ${PHP_MAX_FILE_UPLOADS}" >> $target
    echo "memory_limit = ${PHP_MEMORY_LIMIT}" >> $target
done

# Altera o APP_URL diretamente no .env
sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env
sed -i "s|^FRONTEND_URL=.*|FRONTEND_URL=${FRONTEND_URL}|" .env
sed -i "s|^APP_NAME=.*|APP_NAME=${APP_NAME}|" .env
sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV}|" .env
sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG}|" .env
sed -i "s|^APP_TIMEZONE=.*|APP_TIMEZONE=${APP_TIMEZONE}|" .env
sed -i "s|^DRIVER_STORAGE_PATH=.*|DRIVER_STORAGE_PATH=${DRIVER_STORAGE_PATH}|" .env

# Altera as env de database da aplicação diretamente no .env
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION}|" .env
sed -i "s|^DB_HOST=.*|DB_HOST=${DB_HOST}|" .env
sed -i "s|^DB_PORT=.*|DB_PORT=${DB_PORT}|" .env
sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env
sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|" .env
sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|" .env

# Altera as env de cache diretamente no .env
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=${CACHE_STORE}|" .env
sed -i "s|^CACHE_DRIVER=.*|CACHE_DRIVER=${CACHE_DRIVER}|" .env
sed -i "s|^REDIS_CLIENT=.*|REDIS_CLIENT=${REDIS_CLIENT}|" .env
sed -i "s|^REDIS_CACHE_CONNECTION=.*|REDIS_CACHE_CONNECTION=${REDIS_CACHE_CONNECTION}|" .env
sed -i "s|^REDIS_DB=.*|REDIS_DB=${REDIS_DB}|" .env
sed -i "s|^REDIS_HOST=.*|REDIS_HOST=${REDIS_HOST}|" .env
sed -i "s|^REDIS_PASSWORD=.*|REDIS_PASSWORD=${REDIS_PASSWORD}|" .env
sed -i "s|^REDIS_PORT=.*|REDIS_PORT=${REDIS_PORT}|" .env

# Criar link simbólico para storage
php artisan storage:link

# Ajustar permissões
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Iniciar a aplicação
exec "$@"
