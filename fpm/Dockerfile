FROM php:8.2-fpm

RUN apt-get update && apt-get install zlib1g-dev \
&& pecl install redis \
&& pecl install memcache \
&& docker-php-ext-enable redis \
&& docker-php-ext-enable memcache \
&& docker-php-ext-install mysqli

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
