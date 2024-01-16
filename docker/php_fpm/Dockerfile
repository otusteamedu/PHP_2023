FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        libfreetype-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libmemcached-dev zlib1g-dev libssl-dev \
        libzip-dev libicu-dev\
        && docker-php-ext-configure intl \
        && docker-php-ext-install intl

COPY ./php_fpm/conf.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

VOLUME /app

WORKDIR /app

CMD ["php-fpm"]