FROM php:8.1-rc-fpm

ARG user
ARG uid

RUN apt-get update && \
    apt-get install -y libmemcached-dev zlib1g-dev git && \
    pecl install redis && \
    pecl install memcached && \
    docker-php-ext-enable redis memcached

COPY zz-docker.conf "$PHP_INI_DIR/../php-fpm.d/zz-docker.conf"
COPY php-session.ini "$PHP_INI_DIR/conf.d/php-session.ini"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G users -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user

WORKDIR /var/www/application.local

VOLUME /var/www/application.local

CMD ["php-fpm"]
