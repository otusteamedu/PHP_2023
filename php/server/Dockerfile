FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nano \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) sockets \
    && pecl install memcached && \
    docker-php-ext-enable memcached

COPY config/php.ini /usr/local/etc/php/conf.d/php-custom.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/

VOLUME /var/www/

CMD ["php-fpm"]