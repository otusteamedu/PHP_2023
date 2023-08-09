FROM composer:2 as composer

FROM php:8.1-fpm as php_fpm

COPY php/ /

ARG GID=1000
ARG UID=1000

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN addgroup --gid $GID warp \
    && adduser --system --home /home/warp --shell /bin/bash --uid $UID --ingroup warp --disabled-password warp \
    && mkdir -p /home/warp/app \
    && chown -R warp:warp /home/warp

USER warp
WORKDIR /home/warp/app