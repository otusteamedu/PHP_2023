# syntax=docker/dockerfile:1.4
FROM php:8.2-cli-alpine3.17 as app_php

RUN  --mount=type=bind,from=mlocati/php-extension-installer:1.5,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
      install-php-extensions opcache zip xsl dom exif intl pcntl bcmath sockets && \
     apk del --no-cache  ${PHPIZE_DEPS} ${BUILD_DEPENDS}

WORKDIR /app

# Host system user id, default 1000, but can be passed on buildtime
ARG UID
ARG GID
ARG UNAME
ARG UGROUP
#
## Add user
RUN addgroup -g ${GID} -S ${UGROUP} && adduser --uid ${UID} --ingroup ${UGROUP} -S -g ${UGROUP} ${UNAME} && \
    chown -R ${UNAME}:${UGROUP} /app

RUN mkdir -p /etc/ssl/elasticsearch
RUN chown ${UNAME}:${UGROUP} -R /etc/ssl/elasticsearch

COPY --chown=${UNAME}:${UGROUP} .docker/elk/tls/certs/elasticsearch/elasticsearch.* /etc/ssl/elasticsearch/
RUN chmod -R 700 /etc/ssl/elasticsearch

USER ${UNAME}

ENV COMPOSER_HOME="/tmp/composer"

COPY --chown=${UNAME}:${UGROUP} --from=composer:2.3 /usr/bin/composer /usr/bin/composer
COPY --chown=${UNAME}:${UGROUP} ./app/composer.* .

#RUN composer install --no-dev --no-scripts --prefer-dist --no-progress --no-interaction
RUN composer install --no-scripts --no-progress --no-interaction

COPY --chown=${UNAME}:${UGROUP} ./app .

FROM app_php as app_php_dev
USER root
RUN  --mount=type=bind,from=mlocati/php-extension-installer:1.5,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
      install-php-extensions xdebug && \
     apk del --no-cache  ${PHPIZE_DEPS} ${BUILD_DEPENDS}

COPY .docker/php/config/dev.ini /usr/local/etc/php/conf.d/

USER ${UNAME}

EXPOSE 9000

FROM app_php as app_php_prod
USER root
COPY .docker/php/config/prod.ini /usr/local/etc/php/conf.d/
USER ${UNAME}
