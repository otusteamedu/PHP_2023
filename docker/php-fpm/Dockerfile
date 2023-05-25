FROM php:8.1-fpm-alpine3.17

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

COPY ./docker/php-fpm/entrypoint.sh /entrypoint.sh
COPY ./docker/php-fpm/config/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./docker/php-fpm/config/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./docker/php-fpm/config/php.ini /usr/local/etc/php/conf.d/application.ini

RUN install-php-extensions memcached

WORKDIR /var/www/app

COPY ./src .

RUN composer install --no-interaction
