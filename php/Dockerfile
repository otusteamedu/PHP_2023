FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN mkdir /data && \
    mkdir /data/default && \
    chown -R www-data:www-data /data && \
    curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && \
    apt-get update -y &&  \
    apt-get -y install gcc make autoconf libc-dev pkg-config libzip-dev &&  \
    apt-get install -y --no-install-recommends \
	git

RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pgsql

WORKDIR /data

# USER www-data
CMD ["php-fpm"]
