# Use the official nginx/unit image with PHP 8.1
FROM nginx/unit:1.29.1-php8.1

# Install necessary dependencies for Composer and mysqli
RUN apt-get update \
    && apt-get install -y curl git unzip libonig-dev libzip-dev libpq-dev libssl-dev libicu-dev \
    && docker-php-ext-install mysqli pdo_mysql intl zip opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/app

# Copy the application files to the container
COPY ./app /var/www/app

# Install PHP dependencies
RUN composer install --no-scripts --no-dev --no-interaction

# Copy the Unit configuration file
COPY ./unit-config.json /docker-entrypoint.d/config.json
