FROM php:8.2-fpm

RUN mkdir -p /var/www/otusphp.local

WORKDIR /var/www/otusphp.local

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug-3.3.0 \
    && docker-php-ext-enable xdebug

RUN chown -R www-data:www-data /var/www/otusphp.local
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

CMD ["php-fpm"]
