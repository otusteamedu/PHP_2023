FROM php:8.1

WORKDIR /socket

RUN apt-get update && apt-get install -y \
    procps \
	libzip-dev \
	libmcrypt-dev \
    zip \
    unzip \
    git \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    \
    && set -x \
    && deluser www-data \
    && groupadd --gid 1000 www-data \
    && useradd --gid 1000 www-data \
    && chown -R www-data:www-data /socket

WORKDIR /data/application

RUN chown -R www-data:www-data /data

USER www-data

CMD ["tail", "-f", "/dev/null"]
