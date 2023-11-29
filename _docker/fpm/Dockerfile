FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libmemcached-dev  \
        libssl-dev \
        zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini   "$PHP_INI_DIR/php.ini"
COPY ./zz-docker.conf   /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html/

VOLUME /var/www/html/

CMD ["php-fpm"]

