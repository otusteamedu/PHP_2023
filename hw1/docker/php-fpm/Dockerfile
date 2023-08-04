FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
	libpq-dev \
    && pecl install mcrypt-1.0.5 \
	&& docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring pdo_pgsql pgsql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && pecl install redis \
    && docker-php-ext-enable redis.so

#Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
