FROM php:7.4.33-fpm-alpine3.16
#FROM php:8.1.22-fpm-alpine

#RUN docker-php-ext-install sockets

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /data/app.local
