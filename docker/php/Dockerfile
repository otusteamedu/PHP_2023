FROM php:8.1.22-fpm-alpine

RUN docker-php-ext-install sockets

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /var/www

VOLUME /var/www
