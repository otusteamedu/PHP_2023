FROM php:8.1-apache

RUN apt-get update \
    && apt-get install -y libzip-dev zip libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

RUN a2enmod rewrite
