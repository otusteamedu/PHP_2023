FROM php:8.1-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
        && pecl install mcrypt-1.0.5 \
	&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
     && pecl install memcached && \
        docker-php-ext-enable memcached

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY zz-docker.conf "$PHP_INI_DIR/../php-fpm.d/zz-docker.conf"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer self-update --2
RUN mkdir -p /home/$user/.composer

WORKDIR /data

VOLUME /data
VOLUME /var/run/php-socket/php-fpm.sock

CMD ["php-fpm"]
