#!/bin/bash

set -e

# Comandos de inicialização do contêiner
echo "Container started"

# Rodar migrations
php artisan migrate --force

# Rodar seeds
php artisan db:seed --force

# Copiar o arquivo .env
if [ ! -f "/var/www/.env" ]; then
    cp /var/www/.env.example /var/www/.env
fi

exec php-fpm