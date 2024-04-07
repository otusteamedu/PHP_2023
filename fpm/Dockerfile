# Use the official PHP image with PHP-FPM
FROM php:8.2-fpm

# Fix for "Hash Sum mismatch" error
RUN rm -rf /var/lib/apt/lists/*

# Install system dependencies
RUN apt-get clean && apt-get update --fix-missing && apt-get install -y \
    git \
    libzip-dev \
    libpq-dev \
    libmemcached-dev \
    zlib1g-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    zip \
    pcntl \
    sockets

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Xdebug and PHP extension installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN mkdir -p /var/log/ && touch /var/log/xdebug.log && chmod 777 /var/log/xdebug.log

RUN install-php-extensions xdebug memcached

# Configure Xdebug
ENV PHP_IDE_CONFIG 'serverName=app'
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Set the working directory to /var/www
WORKDIR /data

# Define volume
VOLUME /data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
