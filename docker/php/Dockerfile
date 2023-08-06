FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update \
	&& apt-get install -y libmemcached-dev libssl-dev zlib1g-dev \
	&& pecl install redis \
	&& pecl install memcached-3.2.0 \
	&& docker-php-ext-enable redis memcached \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-enable mysqli

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
