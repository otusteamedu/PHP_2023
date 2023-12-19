FROM php:8.2.13-fpm-alpine3.18

RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        curl \
        wget \
        icu-dev \
        git \
        libzip-dev \
        libmcrypt-dev \
        postgresql-dev \
        libmemcached-dev \
        linux-headers \
     && pecl install mcrypt \
        redis \
        memcached \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) intl \
        zip \
        sockets \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini

COPY zz-docker.conf /usr/local/etc/php-fpm.d/
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
