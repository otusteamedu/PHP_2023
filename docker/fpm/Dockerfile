FROM php:7.4.33-fpm-alpine3.16

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /data/app.local
