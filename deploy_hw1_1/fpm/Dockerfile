FROM php:8.1-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmemcached-dev \
    libmcrypt-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcached && \
    docker-php-ext-enable memcached

#COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY php-fpm.conf "$PHP_INI_DIR/../php-fpm.d/zz-docker.conf"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

WORKDIR /var/www

USER $user

EXPOSE 9000

CMD ["php-fpm"]
