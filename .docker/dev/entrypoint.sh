#!/bin/bash

# Definir um limite de memória padrão ou usar uma variável de ambiente
PHP_MEMORY_LIMIT=${PHP_MEMORY_LIMIT:-512M}

echo "memory_limit = ${PHP_MEMORY_LIMIT}" > /usr/local/etc/php/conf.d/99-custom.ini

php artisan storage:link
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Iniciar a aplicação
exec "$@"
