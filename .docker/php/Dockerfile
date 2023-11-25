FROM php:8.0-fpm
ARG UID
RUN apt-get update  \
    && apt-get install -y --no-install-recommends \
        curl \
        libzip-dev \
        libmemcached-dev \
        zlib1g-dev \
	&& docker-php-ext-install opcache \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && usermod -u $UID www-data \
    && groupmod -g $UID www-data;