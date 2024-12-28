#!/bin/bash

set -e

cd /var/www

composer install
php artisan key:generate
php artisan optimize

supervisord -n -c /etc/supervisord.conf &

exec "$@"

