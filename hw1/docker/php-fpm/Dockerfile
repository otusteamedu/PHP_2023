FROM php:8.1-fpm

RUN apt-get update; \
    apt-get install -y \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    libmemcached-dev \
    libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql pdo zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --preview

COPY zz-docker.conf "$PHP_INI_DIR/../php-fpm.d/zz-docker.conf"

VOLUME /sockets/php-fpm

CMD ["php-fpm"]
