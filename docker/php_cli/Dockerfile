FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
        libfreetype-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libmemcached-dev zlib1g-dev libssl-dev \
        libzip-dev zip \
        && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

VOLUME /app

WORKDIR /app
