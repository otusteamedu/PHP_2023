FROM php:8.2-fpm-alpine

RUN apk update && apk upgrade \
        mc \
	    libpng-dev \
	    libzip-dev \
	    libmemcached-dev \
	    libmcrypt-dev \
        && docker-php-ext-install -j$(nproc) mbstring mysqli pdo_mysql zip \
	    && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

COPY docker/fpm/php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www

VOLUME /var/www

EXPOSE 9000

CMD ["php-fpm"]
