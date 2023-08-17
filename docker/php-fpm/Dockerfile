FROM php:8.2-fpm

RUN rm /etc/apt/preferences.d/no-debian-php

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
	libmhash2 libmhash-dev libc-client-dev libkrb5-dev libssh2-1-dev php-redis

RUN pecl install memcached && \
	pecl install mcrypt  && \
	docker-php-ext-enable memcached

RUN EXPECTED_CHECKSUM="$(wget -q -O - https://composer.github.io/installer.sig)" && \
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" && \
	if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then >&2 echo 'ERROR: Invalid installer checksum' && exit 1; fi && \
	php composer-setup.php --quiet && rm composer-setup.php && \
	mv composer.phar /usr/local/sbin/composer && \
	chmod +x /usr/local/sbin/composer

ADD php.ini /usr/local/etc/php/

RUN apt-get remove -y git && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /