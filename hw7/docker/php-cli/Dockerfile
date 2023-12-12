FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY ./composer.json .

RUN composer install --no-interaction --optimize-autoloader
