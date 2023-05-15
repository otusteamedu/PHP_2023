FROM php:8.2-fpm

# Install PHP Redis Extension
RUN pecl install redis \
    && docker-php-ext-enable redis

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy your application's source files into the container
COPY . /var/www/html
