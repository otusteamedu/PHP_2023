FROM php:8.1-rc-fpm

RUN apt-get update && \
    apt-get install -y libmemcached-dev zlib1g-dev && \
    pecl install redis && \
    pecl install memcached && \
    docker-php-ext-enable redis memcached

COPY zz-docker.conf "$PHP_INI_DIR/../php-fpm.d/zz-docker.conf"
COPY php-session.ini "$PHP_INI_DIR/conf.d/php-session.ini"

COPY composer-setup /tmp/composer-setup

RUN php /tmp/composer-setup --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/application.local

VOLUME /var/www/application.local
VOLUME /var/run/d-socket

CMD ["php-fpm"]
