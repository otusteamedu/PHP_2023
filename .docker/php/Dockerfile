# syntax=docker/dockerfile:1.4
FROM php:8.2-fpm

RUN  --mount=type=bind,from=mlocati/php-extension-installer:1.5,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
      install-php-extensions opcache zip xsl dom exif intl pcntl bcmath sockets pdo_pgsql xdebug

WORKDIR /app

# Host system user id, default 1000, but can be passed on buildtime
ARG UID
ARG GID
ARG UNAME
ARG UGROUP

RUN addgroup --gid $GID --system ${UGROUP} \
 && adduser --uid $UID --system --disabled-login --disabled-password --gid $GID ${UNAME}

RUN chown ${UNAME}:${UGROUP} /app

RUN mkdir -p /var/run/php
RUN chown ${UNAME}:${UGROUP} /var/run/php

USER ${UNAME}

ENV COMPOSER_HOME="/tmp/composer"

COPY --chown=${UNAME}:${UGROUP} --from=composer:2.3 /usr/bin/composer /usr/bin/composer
COPY --chown=${UNAME}:${UGROUP} ./app/composer.* .

COPY --chown=${UNAME}:${UGROUP} ./app .
COPY .docker/php/config/app.ini /usr/local/etc/php/conf.d/
COPY .docker/php/config/dev.ini /usr/local/etc/php/conf.d/

EXPOSE 9000

CMD ["php-fpm"]

