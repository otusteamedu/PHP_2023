FROM php:8.2-fpm

# Install dependencies
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
	&& docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip gd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && pecl install memcached && \
	docker-php-ext-enable memcached \
    && pecl install redis && \
	docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000
CMD ["php-fpm"]