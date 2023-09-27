FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
    zlib1g-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install iconv mbstring pdo pdo_mysql mysqli zip \
    && docker-php-ext-enable mysqli \
   # && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
   # && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/mysite.local

VOLUME /data

CMD ["php-fpm"]
