FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y \
        libxml2-dev \
        libssl-dev \
    && docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/application.local

WORKDIR /var/www/application.local

# Команда для запуска сервера при старте контейнера
#CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/application.local"]

