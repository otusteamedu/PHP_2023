FROM php:8.1.18-fpm-alpine

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /data/app.local
