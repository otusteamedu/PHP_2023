# Use the official Debian-based PHP image
FROM php:8.2-fpm

# Update package lists and install system dependencies
RUN apt-get update && apt-get install -y \
        git \
        zlib1g-dev \
        libzip-dev \
        libpq-dev

# Retry apt-get update with --fix-missing
RUN apt-get update --fix-missing -y

# Install PHP extensions for PostgreSQL
RUN docker-php-ext-install pdo_pgsql pgsql # Install pdo_pgsql and pgsql extensions

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Set working directory
WORKDIR /data

# Define volume
VOLUME /data

# Start php-fpm server
CMD ["php-fpm"]
