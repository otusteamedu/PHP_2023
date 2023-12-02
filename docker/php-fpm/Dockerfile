FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        libzip-dev \
        libmemcached-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

COPY ./php.conf /usr/local/etc/php-fpm.d/zz-docker.conf

EXPOSE 9000
WORKDIR /data
VOLUME /data