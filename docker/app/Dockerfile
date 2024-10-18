FROM php:8.2-fpm

EXPOSE 9000

RUN apt-get update --allow-releaseinfo-change \
    && apt-get install -y --no-install-recommends gnupg \
    g++ \
    procps \
    openssl \
    git \
    curl \
    unzip \
    wget \
    libmemcached-dev libssl-dev zlib1g-dev \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    librabbitmq-dev \
    acl \
    libpq-dev \
    libxml2-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure sockets \
    && pecl install memcached-3.2.0 \
    && docker-php-ext-enable memcached \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql zip xsl gd intl opcache exif calendar soap \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && rm -rf /tmp/pear

RUN pecl install --force redis && docker-php-ext-enable redis

WORKDIR /data

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

CMD ["php-fpm"]