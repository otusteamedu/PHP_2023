FROM php:8.1-fpm

WORKDIR /socket

RUN apt-get update && apt-get install -y \
    procps \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    \
    && set -x \
    && deluser www-data \
    && groupadd --gid 1000 www-data \
    && useradd --gid 1000 www-data \
    \
    && rm /usr/local/etc/php-fpm.d/zz-docker.conf \
    \
    && chown -R www-data:www-data /socket

RUN docker-php-ext-install sockets
WORKDIR /data

RUN chown -R www-data:www-data /data

USER www-data

CMD ["php-fpm", "--nodaemonize"]
