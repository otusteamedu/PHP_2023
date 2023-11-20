FROM php:8.2-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev \
    && pecl install redis \
    && pecl install memcache \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable memcache \
    && docker-php-ext-install mysqli zip

RUN apt-get install -y unzip

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
