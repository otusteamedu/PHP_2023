FROM php:8.3.1-cli-alpine3.19

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR /app

#CMD ["composer", "install"]
#CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app"]
