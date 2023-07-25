FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        && docker-php-ext-install sockets

WORKDIR /chat

VOLUME /chat