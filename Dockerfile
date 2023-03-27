FROM php:8.2-fpm-alpine

RUN apk add --no-cache libzip-dev && \
    docker-php-ext-install zip

WORKDIR /var/www/html

COPY composer.* ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    php /usr/local/bin/composer install --no-autoloader --no-scripts --prefer-dist --no-progress --no-suggest && \
    php /usr/local/bin/composer clear-cache && \
    php /usr/local/bin/composer dump-autoload --optimize --no-dev --classmap-authoritative

CMD ["php-fpm"]

EXPOSE 9000
