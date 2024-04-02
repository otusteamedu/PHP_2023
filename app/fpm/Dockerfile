FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libz-dev \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    git \
    curl \
    libmemcached-dev \
    libpq-dev \
    postgresql-client \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) iconv mbstring pdo_pgsql pgsql zip gd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
