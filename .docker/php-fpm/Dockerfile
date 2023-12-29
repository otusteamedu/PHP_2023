FROM php:8.3.0-fpm-alpine3.19

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN apk --update add --virtual build-dependencies build-base openssl-dev autoconf \
    && pecl install mongodb \
      && docker-php-ext-enable mongodb \
    && pecl install redis \
      && docker-php-ext-enable redis \
    && apk del build-dependencies build-base openssl-dev autoconf \
      && rm -rf /var/cache/apk/*

WORKDIR /data
