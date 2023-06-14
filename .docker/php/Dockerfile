# syntax=docker/dockerfile:1.4
FROM php:8.2-cli-alpine3.18 as default

RUN  --mount=type=bind,from=mlocati/php-extension-installer:2.1,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     apk update && \
      install-php-extensions opcache sockets && \
     apk del --no-cache  ${PHPIZE_DEPS} ${BUILD_DEPENDS}

WORKDIR /var/www

FROM default as server

CMD ["/usr/local/bin/php", "server/index.php"]
