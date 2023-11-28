FROM php:8.1.19-fpm-alpine3.16

RUN apk update && \
    apk add bash && \
    docker-php-ext-install sockets

WORKDIR /var/www

CMD ["php-fpm"]
