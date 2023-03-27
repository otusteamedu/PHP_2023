FROM php:8.2-fpm-alpine

RUN apt-get update && \
    apt-get install -y libzip-dev && \
    docker-php-ext-install zip

WORKDIR /var/www/html

COPY composer.* ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-autoloader && \
    composer dump-autoload --optimize --no-dev --classmap-authoritative

CMD ["php-fpm"]

EXPOSE 9000
