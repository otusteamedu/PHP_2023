#FROM php:8.1.26-fpm-alpine3.19
#FROM php:8.2.13-fpm-alpine3.19
FROM php:8.3.0-fpm-alpine3.19

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

#WORKDIR /data/app.local
WORKDIR /data

#VOLUME /data

CMD ["php-fpm"]
