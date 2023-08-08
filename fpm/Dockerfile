FROM php:8.2.8-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    libmemcached-dev \
    libssl-dev \
    zlib1g-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcached-3.2.0 \
   	&& docker-php-ext-enable memcached \
    && pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install sockets

#mysite - пользователь для docker.sock, nginx создаю здесь и добавляю в группу сокета
RUN adduser --disabled-password mysite \
    && adduser --disabled-password nginx \
    && usermod -a -G mysite nginx

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

RUN chown -R mysite:mysite /data \
    && chmod -R u=rwX,g=rX,o= /data

CMD ["php-fpm"]
