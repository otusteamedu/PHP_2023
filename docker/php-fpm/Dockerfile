FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        libzip-dev \
        libmemcached-dev \
    && pecl install redis \
    && pecl install memcached \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable memcached \
    && docker-php-ext-enable pdo_mysql

COPY ./config/php.conf /usr/local/etc/php-fpm.d/zz-docker.conf
# COPY ./config/php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data
VOLUME /data
CMD ["php-fpm"]
