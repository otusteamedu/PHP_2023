FROM php:8.1-fpm

WORKDIR /var/www/html

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install libzip-dev -y --no-install-recommends \
    curl \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libssl-dev \
    libxpm-dev \
    libmcrypt-dev \
    libonig-dev \
    build-essential \
    locales \
    zip \
    vim \
    unzip \
    git \
    curl;

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql zip exif pcntl

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

#WORKDIR /data/application

RUN chown -R www:www /var/www/html

USER www

EXPOSE 9000
CMD ["php-fpm"]
