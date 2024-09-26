######
# See: https://hub.docker.com/_/php/
######

FROM php:8.2-fpm-alpine
MAINTAINER Dushinov Dmitriy <example@example.ru>
LABEL version="1.0"
LABEL description="php-fpm"

######
# install dependencies PHP
######
RUN apk --no-cache update && \
    apk --no-cache add --update alpine-sdk && \
    apk --no-cache add \
    freetype-dev \
    jpeg-dev \
	  libpng-dev \
	  libzip-dev \
	  libmemcached-dev \
	  zlib-dev \
    libmcrypt-dev \
    tzdata \
    ; \
    \
	  docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp; \
    \
	  docker-php-ext-install -j$(nproc) pdo_mysql iconv mbstring mysqli zip gd; \
    \
    pecl install memcached-3.2.0; \
    pecl install redis-6.0.2; \
    \
    docker-php-ext-enable memcached; \
    docker-php-ext-enable redis;

######
# difine timezone
######
ENV TZ=Europe/Moscow
RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime

######
# Configurations
######
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY ./developer/php-fpm/conf.d /usr/local/etc/php/conf.d
COPY ./developer/php-fpm/php-fpm.d /usr/local/etc/php-fpm.d

######
# workdir
######
WORKDIR /app
