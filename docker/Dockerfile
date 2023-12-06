FROM php:8.2-cli

RUN apt-get update
RUN docker-php-ext-install sockets

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

ENV SOCKET=/www/socket.sock
