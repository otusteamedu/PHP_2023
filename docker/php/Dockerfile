FROM php:8.2-fpm

ARG UID
ARG DOCKER_PHP_ENABLE_XDEBUG

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
      && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	  && docker-php-ext-configure gd --with-freetype --with-jpeg \
      && docker-php-ext-install -j$(nproc) gd \
      && pecl install memcached && \
         docker-php-ext-enable memcached

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

# Ставим xdebug
RUN if [ "$DOCKER_PHP_ENABLE_XDEBUG" = "on" ]; then \
    pecl install xdebug \
    && docker-php-ext-enable xdebug; \
    fi

# ставим composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
