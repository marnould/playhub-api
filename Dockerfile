FROM composer:2 AS builder
WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

FROM php:8.3.12-fpm-alpine

RUN apk add --no-cache \
    zlib \
    libzip-dev \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY . .

EXPOSE 9000

## Enable OPCache for better performance
RUN docker-php-ext-install opcache

CMD ["php-fpm"]