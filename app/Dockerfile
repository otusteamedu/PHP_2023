FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && \
    apt-get update -y &&  \
    apt-get -y install gcc make autoconf libc-dev pkg-config libzip-dev &&  \
    apt-get install -y --no-install-recommends \
	git \
	libmemcached-dev \
	libz-dev \
	libpq-dev \
#	libssl-dev libssl-doc libsasl2-dev \
	libmcrypt-dev \
	libxml2-dev \
	zlib1g-dev libicu-dev g++ \
	libldap2-dev libbz2-dev \
	curl libcurl4-openssl-dev \
	libgmp-dev firebird-dev libib-util \
	re2c libpng++-dev \
	libwebp-dev libjpeg-dev libjpeg62-turbo-dev libpng-dev libxpm-dev libvpx-dev libfreetype6-dev \
	libmagick++-dev \
	libmagickwand-dev \
	zlib1g-dev libgd-dev \
	libtidy-dev libxslt1-dev libmagic-dev libexif-dev file \
#	sqlite3 libsqlite3-dev libxslt-dev \
	libmhash2 libmhash-dev libc-client-dev libkrb5-dev libssh2-1-dev unzip libpcre3 libpcre3-dev poppler-utils \
    ghostscript libmagickwand-6.q16-dev libsnmp-dev libedit-dev libreadline6-dev libsodium-dev freetds-bin freetds-dev \
    freetds-common libct4 libsybdb5 tdsodbc libreadline-dev librecode-dev libpspell-dev libonig-dev && \
    pecl install ds && \
	pecl install imagick && \
	pecl install igbinary && \
	pecl install redis && \
	pecl install memcached && \
    pecl install xdebug && \
	docker-php-ext-install opcache pdo pdo_pgsql pgsql && \
	docker-php-ext-enable ds imagick igbinary memcached xdebug redis opcache && \
    chown -R www-data:www-data /data

WORKDIR /data

# USER www-data
CMD ["php-fpm"]
