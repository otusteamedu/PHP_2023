FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	      libpng-dev \
				libonig-dev \
				libzip-dev \
				libmemcached-dev \
				zlib1g-dev \
        libssl-dev \
				libmcrypt-dev \
        && pecl install redis \
    		&& docker-php-ext-enable redis \
        && pecl install mcrypt \
				&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip sockets \
				&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
     		&& pecl install memcached && \
        docker-php-ext-enable memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

CMD ["php-fpm"]
