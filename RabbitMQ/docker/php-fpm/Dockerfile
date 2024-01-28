FROM php:8.2-fpm

# Download script to install PHP extensions and dependencies
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++ libssl-dev

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN apt-get update \
    && docker-php-ext-install sockets \
    && install-php-extensions pdo_pgsql \
    && rm -rf /var/lib/apt/lists/* && rm -rf /tmp/* && rm -rf /var/log/*

WORKDIR /data