FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y libpq-dev zlib1g-dev && \
    docker-php-ext-install sockets

WORKDIR /app

VOLUME /app

CMD ["php-fpm"]