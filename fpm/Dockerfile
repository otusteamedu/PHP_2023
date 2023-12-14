FROM php:8.2-fpm

#RUN apt-get update && apt-get install -y \
#        libmemcached-dev \
#	&& docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
#	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
#	&& docker-php-ext-install -j$(nproc) gd \
#    && pecl install memcached && \
#    docker-php-ext-enable memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY zz-docker.conf "$PHP_INI_DIR/../php-fpm.d/zz-docker.conf"

WORKDIR /data

VOLUME /data
VOLUME /var/run/php-fpm.sock

CMD ["php-fpm"]
