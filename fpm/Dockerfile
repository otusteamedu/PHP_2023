FROM php:7.4-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
        && pecl install mcrypt-1.0.3 \
	&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
	&& chmod +x /usr/local/bin/install-php-extensions  \
	&& install-php-extensions @composer-2

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./custom.conf /usr/local/etc/php-fpm.d/zz-docker.conf
# COPY ./pool.d/www.conf /usr/local/etc/php/conf.d/www.conf

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
