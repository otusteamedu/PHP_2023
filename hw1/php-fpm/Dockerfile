FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
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
    && pecl install mcrypt memcached redis \
    && docker-php-ext-enable mcrypt memcached redis \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/zzz-custom.conf

EXPOSE 9000

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
