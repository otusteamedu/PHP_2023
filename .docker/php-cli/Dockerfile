FROM php:8.1.27-cli-alpine3.19

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN docker-php-ext-install sockets \
  && apk --update add --virtual build-dependencies build-base openssl-dev autoconf \
    && pecl install redis \
      && docker-php-ext-enable redis \
  && apk del build-dependencies build-base openssl-dev autoconf \
    && rm -rf /var/cache/apk/* && rm -rf /tmp/*

WORKDIR /data

CMD ["php", "-f", "public/index.php", "get", "all"]
