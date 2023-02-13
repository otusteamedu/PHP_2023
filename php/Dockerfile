# Получение образа php 8.2 fpm
FROM php:8.2-fpm

# Ставим модули необходимые для работы
RUN apt-get update && apt-get install -y \
    memcached \
    libmemcached-dev \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install zip \
    && apt-get clean

# COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

# Рабочая дирректория www
WORKDIR /www

# Монтируем папку www
VOLUME /www

CMD ["php-fpm"]