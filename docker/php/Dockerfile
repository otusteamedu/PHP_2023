FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    graphviz \
    libpq-dev \
    libmemcached-dev \
    libmemcached11 \
   && docker-php-ext-configure gd \
   && docker-php-ext-install -j$(nproc) gd \
   && docker-php-ext-install zip \
   && docker-php-ext-install sockets \
   && docker-php-source delete \
   && curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer \
   && pecl install redis \
   && docker-php-ext-enable redis \
   && pecl install apcu \
   && pecl install memcached

EXPOSE 9000
CMD ["php-fpm"]
