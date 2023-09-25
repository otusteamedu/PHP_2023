FROM php:8.1-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get install -y libpq-dev zlib1g-dev libzip-dev unzip && \
    docker-php-ext-install zip sockets



WORKDIR /data/mysite.local

VOLUME /data/mysite.local

CMD ["php-fpm"]