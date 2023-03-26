FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN mkdir /data && \
    mkdir /data/mysite.local && \
    chown -R www-data:www-data /data && \
    curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && \
    apt-get update -y &&  \
    apt-get -y install gcc make autoconf libc-dev pkg-config libzip-dev &&  \
    apt-get install -y --no-install-recommends \
	libmemcached-dev \
	libz-dev

RUN pecl install xdebug
RUN docker-php-ext-install sockets
RUN docker-php-ext-enable xdebug sockets


WORKDIR /data

# USER www-data
CMD ["php-fpm"]
# CMD ["php -f /data/default/public/app.php"]
