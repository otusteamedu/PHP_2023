FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
     && pecl install memcached && \
        docker-php-ext-enable memcached

COPY zz-docker.conf "$PHP_INI_DIR/../php-fpm.d/zz-docker.conf"
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./php-fpm2-pool.conf /usr/local/etc/php-fpm.d/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer self-update --2
RUN mkdir -p /home/$user/.composer

WORKDIR /data

VOLUME /data
VOLUME /var/run/php-fpm.sock

CMD ["php-fpm"]
