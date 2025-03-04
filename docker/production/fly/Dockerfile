# syntax = docker/dockerfile:experimental

# Default to PHP 8.2, but we attempt to match
# the PHP version from the user (wherever `flyctl launch` is run)
# Valid version values are PHP 7.4+
ARG PHP_VERSION=8.3
FROM fideloper/fly-laravel:${PHP_VERSION} as base

# PHP_VERSION needs to be repeated here
# See https://docs.docker.com/engine/reference/builder/#understand-how-arg-and-from-interact
ARG PHP_VERSION

LABEL fly_launch_runtime="laravel"

# copy application code, skipping files based on .dockerignore
COPY src /var/www/html

RUN rm -rf /entrypoint
RUN mkdir -p /entrypoint
COPY docker/production/fly/entrypoint /entrypoint

# Copy supervisor configuration for queue workers
COPY docker/production/fly/supervisor-queue.conf /etc/supervisor/conf.d/queue.conf

RUN composer install --optimize-autoloader --no-dev \
    && mkdir -p storage/logs \
    && php artisan optimize:clear \
    && chown -R www-data:www-data /var/www/html \
    && echo "MAILTO=\"\"\n* * * * * www-data /usr/bin/php /var/www/html/artisan schedule:run" > /etc/cron.d/laravel

# Laravel 11 made changes to how trusting all proxies works, see https://laravel.com/docs/11.x/requests#trusting-all-proxies and https://laravel.com/docs/10.x/requests#trusting-all-proxies
RUN if php artisan --version | grep -q "Laravel Framework 1[1-9]"; then \
    sed -i='' '/->withMiddleware(function (Middleware \$middleware) {/a\
        \$middleware->trustProxies(at: "*");\
' bootstrap/app.php; \
  else \
    sed -i 's/protected \$proxies/protected \$proxies = "*"/g' app/Http/Middleware/TrustProxies.php; \
fi

# If we're using Octane...
RUN if grep -Fq "laravel/octane" /var/www/html/composer.json; then \
        rm -rf /etc/supervisor/conf.d/fpm.conf; \
        if grep -Fq "spiral/roadrunner" /var/www/html/composer.json; then \
            mv /etc/supervisor/octane-rr.conf /etc/supervisor/conf.d/octane-rr.conf; \
            if [ -f ./vendor/bin/rr ]; then ./vendor/bin/rr get-binary; fi; \
            rm -f .rr.yaml; \
        else \
            mv .fly/octane-swoole /etc/services.d/octane; \
            mv /etc/supervisor/octane-swoole.conf /etc/supervisor/conf.d/octane-swoole.conf; \
        fi; \
        rm /etc/nginx/sites-enabled/default; \
        ln -sf /etc/nginx/sites-available/default-octane /etc/nginx/sites-enabled/default; \
    fi

EXPOSE 8080

ENTRYPOINT ["/entrypoint/entrypoint.sh"]
CMD ["php-fpm"]