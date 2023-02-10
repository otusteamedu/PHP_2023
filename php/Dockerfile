# Получение образа php 8.2 fpm
FROM php:8.2-fpm

# Ставим модули необходимые для работы
RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && pecl install memcached redis && \
    docker-php-ext-enable memcached redis

# COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

# Рабочая дирректория www
WORKDIR /www

# Монтируем папку www
VOLUME /www

CMD ["php-fpm"]