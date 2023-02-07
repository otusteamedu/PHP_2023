FROM php:8.0.0-fpm
ARG UID
RUN addgroup --gid $UID --system app \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app
# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    && pecl install xdebug-3.0.1 \
        && docker-php-ext-enable xdebug \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Устанавливаем redis
RUN mkdir -p /usr/src/php/ext/redis; \
	curl -fsSL https://pecl.php.net/get/redis --ipv4 | tar xvz -C "/usr/src/php/ext/redis" --strip 1; \
	docker-php-ext-install redis; \
    # Устанавливаем memcache
    cd /tmp && git clone https://github.com/websupport-sk/pecl-memcache && \
    cd pecl-memcache && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    docker-php-ext-enable memcache;

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /data

CMD ["php-fpm"]
