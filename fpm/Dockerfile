FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    wget \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libzip-dev \
    libmemcached-dev \
    zlib1g-dev \
    libicu-dev \
    g++ \
    libmagickwand-dev --no-install-recommends \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip opcache intl \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install memcached && docker-php-ext-enable memcached

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

VOLUME /data

# Назначение прав на директории
RUN chown -R www-data:www-data /data

CMD ["php-fpm"]
