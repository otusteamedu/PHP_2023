FROM composer:2 AS composer

FROM mlocati/php-extension-installer:1.5 as extension_installer

FROM php:8.1-fpm-bullseye AS php_fpm

RUN apt-get update -qq \
    && apt-get install -y --no-install-recommends \
        git \
        wget \
        zip \
    && rm -rf /var/lib/apt/lists /var/cache/apt/archives

# https://github.com/mlocati/docker-php-extension-installer#supported-php-extensions
COPY --from=extension_installer /usr/bin/install-php-extensions /usr/bin/
RUN PICKLE_PECL_UNSAFE=1 IPE_GD_WITHOUTAVIF=1 install-php-extensions \
        mysqli-stable \
        opcache-stable \
        pdo_mysql-stable \
    && rm -rf /usr/bin/install-php-extensions /var/lib/apt/lists /var/cache/apt/archives

COPY php/ /

COPY --from=composer /usr/bin/composer /usr/local/bin

ARG UID=1000
ARG GID=1000

RUN addgroup --gid $GID warp \
    && adduser --system --home /home/warp --shell /bin/bash --uid $UID --ingroup warp --disabled-password warp \
    && mkdir -p /home/warp/app \
    && chown -R warp:warp /home/warp

WORKDIR /home/warp/app

USER warp