FROM php:8.2-cli
ARG UID
RUN apt-get update  \
    && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && usermod -u $UID www-data \
    && groupmod -g $UID www-data;

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer