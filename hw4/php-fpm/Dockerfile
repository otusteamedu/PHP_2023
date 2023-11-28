FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmemcached-dev \
    zlib1g-dev \
    libssl-dev \
    libmcrypt-dev \
    && pecl install mcrypt memcached \
    && docker-php-ext-enable mcrypt memcached \
    && docker-php-ext-install -j$(nproc) iconv mbstring zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini

CMD ["php-fpm"]
