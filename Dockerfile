FROM php:8.2.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev

RUN docker-php-ext-install pdo_mysql intl mbstring zip

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN composer install --no-cache --no-interaction --no-scripts

RUN chown -R www-data:www-data var

RUN chmod +x bin/console

WORKDIR /var/www/html/public

# Указываем команду для запуска PHP-FPM
CMD ["php-fpm"]