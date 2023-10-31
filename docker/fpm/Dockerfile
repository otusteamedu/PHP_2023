FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install iconv mbstring pdo pdo_mysql mysqli zip \
    && docker-php-ext-enable mysqli \
    && docker-php-ext-install sockets \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install xdebug-3.2.2 \
    && docker-php-ext-enable xdebug

#RUN pecl install xdebug \
    #&& docker-php-ext-enable xdebug
COPY ./php.ini /etc/php/8.2/fpm/conf.d/90-php.ini
COPY ./php.ini /etc/php/8.2/cli/conf.d/90-php.ini

WORKDIR /data/mysite.local

VOLUME /data

CMD ["php-fpm"]

EXPOSE 9000