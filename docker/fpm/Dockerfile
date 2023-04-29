FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libpq-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring pdo pdo_pgsql pgsql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcached && \
    docker-php-ext-enable memcached \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /var/run/php-fpm.sock

CMD ["php-fpm"]