FROM php:8.2-fpm

RUN apt-get update  \
    && apt-get install -y \
    && docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/app
VOLUME /data/app

CMD ["composer install"]
CMD ["php-fpm"]
