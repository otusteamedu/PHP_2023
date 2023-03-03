FROM php:8.1-fpm-alpine

RUN addgroup -g 1001 -S web \
    && adduser -u 1001 -S -G web web

# Doc https://github.com/mlocati/docker-php-extension-installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk update && apk add --no-cache --virtual build-deps $PHPIZE_DEPS \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions mcrypt json bcmath gd intl \
    opcache memcached pdo_pgsql pdo_mysql redis zip xdebug @composer \
    && apk del build-deps $PHPIZE_DEPS

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf \
    && rm /usr/local/etc/php-fpm.d/www.conf
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini

STOPSIGNAL SIGTERM

WORKDIR /var/www/html/application.local

CMD ["php-fpm"]
