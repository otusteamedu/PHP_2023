FROM php:fpm

RUN apt-get update \
	&& apt-get install -y libmemcached-dev libssl-dev zlib1g-dev libgmp-dev \
	&& pecl install redis \
	&& pecl install memcached-3.2.0 \
	&& docker-php-ext-enable redis memcached \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-enable mysqli \
    && docker-php-ext-install bcmath \
    && docker-php-ext-enable bcmath \
    && docker-php-ext-install sockets \
    && docker-php-ext-install gmp \
    && apt-get install -y git \
    && mkdir -p /data/config \
    && chmod 777 /data/config

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /data/www

CMD ["./../config/start.sh"]