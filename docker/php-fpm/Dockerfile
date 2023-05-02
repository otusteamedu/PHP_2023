FROM php:8.1-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
        libpq-dev \
	libmemcached-dev \
	libmcrypt-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql pdo pdo_pgsql pgsql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
     && pecl install memcached && \
        docker-php-ext-enable memcached

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY zz-docker.conf "$PHP_INI_DIR/../php-fpm.d/zz-docker.conf"

COPY composer-setup /tmp/composer-setup
RUN php /tmp/composer-setup --install-dir=/usr/bin --filename=composer

WORKDIR /data/app.local

VOLUME /data
VOLUME /var/run/d-socket

CMD ["php-fpm"]
