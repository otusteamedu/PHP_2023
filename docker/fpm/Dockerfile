FROM php:8.2-fpm-alpine


ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk update && apk upgrade \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions memcache redis


COPY docker/fpm/php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www

VOLUME /var/www

EXPOSE 9000

CMD ["php-fpm"]
