FROM php:7.4-fpm

RUN docker-php-ext-install pdo pdo_mysql

COPY code/ /var/www/html/

RUN apt-get update && apt-get install -y libmemcached-dev zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

WORKDIR /var/www/html
VOLUME /var/www/html


CMD ["php-fpm"]
