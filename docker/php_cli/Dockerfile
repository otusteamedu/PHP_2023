FROM php:8.2-cli

RUN apt-get update && apt-get install -y && docker-php-ext-install -j$(nproc) sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

VOLUME /app

WORKDIR /app

