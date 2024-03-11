FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmemcached-dev \
    libz-dev \
    libmcrypt-dev \
    build-essential \
    libpq-dev \
        && pecl install memcached \
        && docker-php-ext-enable memcached \
        && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip gd pdo_pgsql pgsql \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
        && pecl install redis && docker-php-ext-enable redis

CMD ["php-fpm"]
