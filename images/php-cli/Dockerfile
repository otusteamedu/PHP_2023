FROM php:8.2-cli

RUN apt-get update && \
    apt-get install -y git unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

ENTRYPOINT ["composer"]