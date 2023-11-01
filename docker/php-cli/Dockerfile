FROM php:8.2-cli

# ставим необходимые для нормальной работы модули

#RUN pecl install redis-5.3.7 \	&& pecl install xdebug-3.2.1 \	&& docker-php-ext-enable redis xdebug

#RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini


CMD ["php"]
