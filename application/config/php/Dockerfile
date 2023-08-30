FROM php:fpm

RUN apt-get update \
	&& apt-get install -y libmemcached-dev libssl-dev zlib1g-dev libcurl4-gnutls-dev \
	&& pecl install redis \
	&& pecl install memcached-3.2.0 \
	&& docker-php-ext-enable redis memcached \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-enable mysqli \
    && docker-php-ext-install curl \
    && docker-php-ext-enable curl \
    && apt-get install -y git

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /data/www