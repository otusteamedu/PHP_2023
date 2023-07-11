# syntax=docker/dockerfile:1.4
FROM php:8.1-fpm-alpine3.17

COPY ./docker/php/config/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./docker/php/config/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./docker/php/config/php.ini /usr/local/etc/php/conf.d/application.ini

RUN  --mount=type=bind,from=mlocati/php-extension-installer,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
    install-php-extensions redis \
    && apk del --no-cache  ${PHPIZE_DEPS} ${BUILD_DEPENDS}

WORKDIR /var/www/app

ARG UID=1000
ARG GID=1000

RUN addgroup -g ${GID} -S www && adduser --uid ${UID} --ingroup www -S -g www www \
    && mkdir -p /home/www/Downloads /var/www/app \
    && rm -rf /var/www/html \
    && chown -R www:www /home/www \
    && chown -R www:www /var/www/app

ENV COMPOSER_HOME="/tmp/composer"

COPY --chown=www:www --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --chown=www:www ./app/composer.* .

RUN composer config --no-plugins \
    && composer install --no-cache --no-ansi --no-autoloader --no-scripts --no-dev

COPY --chown=www:www ./app/ .

RUN set -x \
    && composer dump-autoload -n --optimize \
    && chmod -R 777 ${COMPOSER_HOME}/cache

CMD ["php-fpm"]
