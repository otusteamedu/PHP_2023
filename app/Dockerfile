FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN mkdir /data && mkdir /data/default && \
    chown -R www-data:www-data /data && \
    curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && \
    apt-get update -y &&  \
    apt-get -y install gcc make autoconf libc-dev pkg-config libzip-dev unzip libpq-dev librabbitmq-dev &&  \
    apt-get install -y --no-install-recommends libz-dev && \
    pecl install amqp xdebug && \
    docker-php-ext-install zip sockets pdo pdo_pgsql && \
    docker-php-ext-enable xdebug zip amqp sockets pdo pdo_pgsql

COPY php-custom.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data/default

# USER www-data
CMD ["php-fpm"]
