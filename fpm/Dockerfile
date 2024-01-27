FROM php:8.2-fpm

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
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]