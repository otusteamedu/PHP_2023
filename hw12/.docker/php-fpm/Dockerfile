FROM php:8.2-fpm

WORKDIR /var/www/otusphp.local

COPY ./php-fpm.conf /usr/local/etc/php-fpm.d/zzz-custom.conf

RUN apt-get update && apt-get install -y  \
    locales  \
    libfreetype6-dev  \
    libjpeg62-turbo-dev  \
    libpng-dev  \
    libonig-dev  \
    libzip-dev  \
    zlib1g-dev  \
    libssl-dev  \
    libmcrypt-dev  \
    && rm -rf /var/lib/apt/lists/* \
    && localedef -i ru_RU -c -f UTF-8 -A /usr/share/locale/locale.alias ru_RU.UTF-8 \
    && pecl install mcrypt redis \
    && docker-php-ext-enable mcrypt redis \
    && docker-php-ext-install -j$(nproc) iconv mbstring zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    #&& COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --no-plugins --no-scripts

CMD ["php-fpm"]
