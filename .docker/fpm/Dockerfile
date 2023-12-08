FROM php:8.1-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
    libmemcached11 \
    zlib1g-dev libssl-dev \
	libmemcached-dev \
	libmcrypt-dev \
#   && pecl install mcrypt-1.0.3 \
    && pecl install mcrypt \
	&& docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
#   && pecl install memcached && \
#   docker-php-ext-enable memcached \
    && chmod +x /usr/local/bin/install-php-extensions  \
    && install-php-extensions redis \
    && install-php-extensions @composer-2 \
    && install-php-extensions memcached

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
