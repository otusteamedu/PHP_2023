FROM php:8.3.0-fpm-alpine3.19

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /data

CMD ["php-fpm"]
