FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libonig-dev \
		libzip-dev \
		unzip \
		libmemcached-dev \
		zlib1g-dev \
		libmemcached11 \
		libssl-dev \
	&& docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd \
	     && pecl install redis  && \
        docker-php-ext-enable redis

RUN yes '' | pecl install -f memcached-3.2.0 \
  && docker-php-ext-enable memcached
RUN docker-php-ext-install sockets

# composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
