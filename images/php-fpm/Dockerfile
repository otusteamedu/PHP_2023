# Образ
FROM php:8.1-fpm


# Обновим, доставим утилиты и экстеншены
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN apt-get update && apt-get install -y --no-install-recommends curl wget git\
    libfreetype-dev libjpeg62-turbo-dev libpng-dev libzip-dev libmemcached-dev libssl-dev\
    && apt-get clean\
    && rm -rf /var/lib/apt/lists/*\
    && docker-php-ext-install -j$(nproc) iconv mysqli pdo_mysql zip\
    && docker-php-ext-configure gd --with-freetype --with-jpeg\
    && pecl install memcached\
    && docker-php-ext-enable memcached\
    && pecl install redis\
    && docker-php-ext-enable redis\
    && pecl install php-dom\
    && docker-php-ext-enable php-dom\
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Прокинем конфиг
COPY php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www

# The main purpose of a CMD is to provide defaults for an executing container. These defaults can include an executable,
# or they can omit the executable, in which case you must specify an ENTRYPOINT instruction as well.
CMD ["php-fpm"]