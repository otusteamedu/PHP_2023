FROM php:8.3.0-fpm-alpine

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /data/app.local
