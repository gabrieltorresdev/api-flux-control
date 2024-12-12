FROM php:8.3-fpm-alpine3.19

WORKDIR /var/www

RUN apk add --no-cache \
    icu-dev \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    bash \
    curl

RUN docker-php-ext-install gd intl mbstring pdo_mysql zip bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN addgroup -g 1000 app \
    && adduser -u 1000 -D -s /bin/bash -G app app

COPY --chown=app:www-data ./src/ /var/www/

RUN chown -R app:www-data /var/www && chmod -R 755 /var/www

USER app

EXPOSE 9000

ENTRYPOINT ["php-fpm"]
