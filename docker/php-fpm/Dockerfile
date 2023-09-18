FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y \
    && apt-get install -y nano \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    libmcrypt-dev \
    && apt-get install -y nano \
    && docker-php-ext-install -j$(nproc) iconv mbstring sockets zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --preview

WORKDIR /var/www/public

VOLUME /var/www/public

VOLUME /sockets/php-fpm

CMD ["php-fpm"]
