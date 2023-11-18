FROM php:8.2-fpm
ARG UID
RUN apt-get update  \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        zlib1g-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd mysqli opcache \
    && pecl install xdebug-3.2.2 redis memcache \
    && docker-php-ext-enable xdebug redis memcache \
    && usermod -u $UID www-data;