FROM php:8.2-fpm

ARG UID
ARG GID
RUN apt-get update && apt-get install -y \
        libfreetype-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libmemcached-dev zlib1g-dev libssl-dev \
        libzip-dev \
	&& docker-php-ext-install -j$(nproc) mysqli pdo_mysql zip \
    && docker-php-ext-enable mysqli \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY ./php_fpm/conf.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./php_fpm/conf.d/php.ini /usr/local/etc/php/conf.d/php_custom.ini

VOLUME /app

WORKDIR /app

CMD ["php-fpm"]