FROM php:8.2-fpm

RUN apt-get update -y && apt-get -y install \
	gcc make autoconf libc-dev pkg-config libzip-dev libfcgi0ldbl nano htop iotop lsof cron redis-tools wget \
	&& apt-get install -y --no-install-recommends \
	git \
	libmemcached-dev \
	libz-dev \
	libpq-dev \
	libssl-dev libssl-doc libsasl2-dev \
	libmcrypt-dev \
	libxml2-dev \
	zlib1g-dev libicu-dev g++ \
	libldap2-dev libbz2-dev \
	curl libcurl4-openssl-dev \
	libmhash2 libmhash-dev libc-client-dev libkrb5-dev libssh2-1-dev \
    && pecl install memcached \
    && pecl install mcrypt \
    && docker-php-ext-enable memcached

ADD php.ini /usr/local/etc/php/

WORKDIR /var/www/otus

CMD ["php-fpm"]