FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libmemcached-dev libssl-dev zlib1g-dev \
	&& pecl install  memcached-3.2.0 \
	&& docker-php-ext-enable memcached \
	&& docker-php-ext-configure  gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd  

RUN apt-get update && apt-get install -y \
	zip libzip-dev \
	&& docker-php-ext-configure zip \
	&& docker-php-ext-install zip

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Добавим свой php.ini, можем в нем определять свои значения конфига
ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

# Указываем рабочую директорию для PHP
WORKDIR /var/www

# Запускаем контейнер
CMD ["php-fpm"]   