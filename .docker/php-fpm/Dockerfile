FROM php:7.4.33-fpm

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y unzip librdkafka-dev && pecl install rdkafka && docker-php-ext-enable rdkafka \
  && docker-php-ext-install sockets \
    && pecl install redis && docker-php-ext-enable redis \
  && rm -rf /var/lib/apt/lists/* && rm -rf /tmp/* && rm -rf /var/log/*

WORKDIR /data
