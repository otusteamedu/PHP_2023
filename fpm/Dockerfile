FROM php:8.2-fpm

RUN apt-get update && \
    docker-php-ext-install sockets

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]