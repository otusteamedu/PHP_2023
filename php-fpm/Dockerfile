FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        procps \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
        && pecl install mcrypt-1.0.5 \
	&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
     && pecl install memcached && \
        docker-php-ext-enable memcached

#RUN groupadd --gid 1000 www && \
#    useradd --gid 1000 www

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /data

#COPY ./www.conf /usr/local/etc/php-fpm.d/www.conf

#RUN chown -R www:www /data
#
#USER www

CMD ["php-fpm", "--nodaemonize"]
