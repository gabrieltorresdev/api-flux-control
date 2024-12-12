#!/bin/bash

set -e

cd /var/www

composer install --no-dev --optimize-autoloader

php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

supervisord -n -c /etc/supervisord.conf &

exec "$@"
