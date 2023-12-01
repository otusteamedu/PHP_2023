######
# See: https://hub.docker.com/_/php/
######

FROM php:8.2-cli-alpine
MAINTAINER Dushinov Dmitriy <example@example.ru>
LABEL version="1.0"
LABEL description="php-cli"

######
# install dependencies PHP
######
RUN apk --no-cache update && \
    apk --no-cache add --update alpine-sdk && \
    apk --no-cache add \
    tzdata;

######
# difine timezone
######
ENV TZ=Europe/Moscow
RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime

######
# Configurations
######
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY ./developer/php-fpm/conf.d /usr/local/etc/php/conf.d

######
# Add user
######
RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

######
# Composer
######
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

######
# workdir
######
WORKDIR /app

######
# Current user
######
USER app
