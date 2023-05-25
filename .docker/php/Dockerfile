# syntax=docker/dockerfile:1.4
FROM php:8.2-fpm-alpine3.17

RUN  --mount=type=bind,from=mlocati/php-extension-installer:2.1,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     apk update && \
      install-php-extensions opcache zip bcmath && \
     apk del --no-cache  ${PHPIZE_DEPS} ${BUILD_DEPENDS}

COPY .docker/php/config/php.ini /usr/local/etc/php/conf.d/php-default.ini

WORKDIR /var/www

CMD ["php-fpm"]
