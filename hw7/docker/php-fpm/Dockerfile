FROM php:8.2-fpm

WORKDIR /var/www/otusphp.local

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

CMD ["php-fpm"]
