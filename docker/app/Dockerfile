FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD ./php.ini 			/usr/local/etc/php/php.ini
ADD ./php-fpm.conf 		/usr/local/etc/php-fpm.conf

RUN mkdir -p /app/

WORKDIR  /app/

EXPOSE 9000

CMD php-fpm