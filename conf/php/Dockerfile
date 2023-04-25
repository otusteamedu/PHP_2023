FROM php:8.2-fpm-alpine

RUN apk --update --no-cache add \
    autoconf \
    libpq-dev \
    build-base \
    && apk add --update linux-headers \
    && docker-php-ext-install pgsql pdo_pgsql \
    && pecl install redis \
    && pecl install xdebug \
    && docker-php-ext-enable redis xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

COPY php.ini /usr/local/etc/php/conf.d/custom-php.ini

WORKDIR /var/www

EXPOSE 9000
CMD ["php-fpm"]