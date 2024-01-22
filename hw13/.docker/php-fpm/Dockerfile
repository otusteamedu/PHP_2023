FROM php:8.2-fpm

RUN mkdir -p /var/www/otusphp.local

WORKDIR /var/www/otusphp.local

RUN apt-get update && apt-get install -y libpq-dev \
    && pecl install redis \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-enable redis

CMD ["php-fpm"]
