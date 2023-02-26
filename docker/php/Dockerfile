FROM php:8.1-fpm-alpine3.17

RUN addgroup -g 10001 -S web \
    && adduser -u 10001 -S -G web web

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk update --no-cache && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions sockets pcntl intl mbstring

STOPSIGNAL SIGTERM

WORKDIR /var/www/html/application.local

CMD ["php-fpm"]
