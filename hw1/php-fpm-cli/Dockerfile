FROM php:8.2-cli

WORKDIR /app

COPY ./composer.json .

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update \
    && apt-get install -y \
    zip \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer update
