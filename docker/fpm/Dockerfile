FROM php:8.1.19-fpm-alpine3.16

RUN apk update && \
    apk add bash && \
    php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer &&  \
    alias composer='php /usr/bin/composer' && \
    docker-php-ext-install sockets

WORKDIR /var/www

CMD ["php-fpm"]