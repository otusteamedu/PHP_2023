FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
	libpq-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql pgsql pdo_pgsql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
     && pecl install memcached && \
        docker-php-ext-enable memcached \
     && pecl install redis && \
        docker-php-ext-enable redis \
     && docker-php-ext-install sockets \
     && curl -sS https://getcomposer.org/installer | php \
        && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

WORKDIR /data/mysite.local

VOLUME /data

CMD bash -c "composer install"
CMD ["php-fpm"]
