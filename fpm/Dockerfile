FROM php:8.2-fpm

RUN apt-get update && apt-get install zlib1g-dev \
&& pecl install redis \
&& pecl install memcache \
&& docker-php-ext-enable redis \
&& docker-php-ext-enable memcache \
&& docker-php-ext-install mysqli

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
