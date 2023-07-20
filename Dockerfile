FROM php:latest

RUN pecl install redis \
    && docker-php-ext-enable redis

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
