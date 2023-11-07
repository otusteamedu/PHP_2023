FROM php:8.2-fpm

EXPOSE 9000

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	    libpng-dev \
	    libonig-dev \
	    libzip-dev \
	    libmcrypt-dev \
        && pecl install mcrypt-1.0.6 \
	    && docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	    && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd 

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data/application.local

VOLUME /data/application.local

CMD ["php-fpm"]