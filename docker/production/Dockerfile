FROM php:8.3-fpm-alpine3.19

WORKDIR /var/www

RUN apk add --no-cache \
    build-base \
    oniguruma-dev \
    icu-dev \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    autoconf \
    linux-headers \
    supervisor

RUN docker-php-ext-install gd intl mbstring pcntl pdo_mysql zip bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache nodejs npm

RUN addgroup -g 1000 app
RUN adduser -u 1000 -D -s /bin/bash -G app app

COPY --chown=app:www-data ./src/ /var/www/

COPY --chown=app:www-data docker/local/config/entrypoint.sh /tmp/
RUN chmod +x /tmp/entrypoint.sh

COPY docker/local/config/supervisor/supervisord.conf /etc/supervisord.conf

USER app

EXPOSE 9000

ENTRYPOINT ["/tmp/entrypoint.sh"]
CMD ["php-fpm"]