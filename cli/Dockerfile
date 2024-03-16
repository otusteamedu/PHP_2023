FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    curl \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev libssl-dev \
	libmcrypt-dev \
    libpq-dev \
    && docker-php-ext-install sockets \
	&& pecl install mcrypt-1.0.6 \
		&& docker-php-ext-enable mcrypt \
	&& docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql pdo_pgsql pgsql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
	&& pecl install memcached \
    	&& docker-php-ext-enable memcached \
    && pecl install redis-5.3.7 \
    	&& docker-php-ext-enable redis \
    && pecl install xdebug-3.2.2 \
        && docker-php-ext-enable xdebug \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
RUN composer self-update

WORKDIR /www

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

#CMD ["php", "composer", "update"]