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
    libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring sockets zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --preview

WORKDIR /var/www/html

VOLUME /var/www/html

VOLUME /sockets/php-fpm

CMD ["php-fpm"]
