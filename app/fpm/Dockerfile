FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libz-dev \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    git \
    curl \
    libmemcached-dev \
    libpq-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip gd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && pecl install memcached \
    && docker-php-ext-enable memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/application.local
COPY ../www/application.local /var/www/application.local

RUN composer install

EXPOSE 9000
CMD ["php-fpm"]