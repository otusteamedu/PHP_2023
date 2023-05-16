FROM php:8.2-fpm

# Install PHP Redis Extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY ./app/composer.json ./

RUN composer install --no-scripts --no-autoloader --no-dev

COPY ./app ./

RUN composer dump-autoload --optimize
