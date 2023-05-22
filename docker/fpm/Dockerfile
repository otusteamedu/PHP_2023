FROM php:8.2-fpm-alpine

RUN apk update && apk upgrade && apk add --no-cache --virtual build-essentials \
      make autoconf \
      libjpeg-turbo-dev libpng-dev libwebp-dev freetype-dev \
	  g++ \
      libmemcached-dev \
      && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
      && docker-php-ext-install gd \
      && pecl install igbinary msgpack memcached redis \
      && docker-php-ext-enable memcached redis \
      && apk del build-essentials && rm -rf /usr/src/php*



WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]
