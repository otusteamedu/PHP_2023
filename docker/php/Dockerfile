FROM php:8.1-fpm

ARG DOCKER_PHP_ENABLE_XDEBUG
ARG uname
ARG gid
ARG uid

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
      && pecl install mcrypt-1.0.5 \
      && pecl install apcu \
	  && docker-php-ext-enable mcrypt \
      && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	  && docker-php-ext-configure gd --with-freetype --with-jpeg \
      && docker-php-ext-install -j$(nproc) gd \
      && pecl install memcached && \
         docker-php-ext-enable memcached apcu

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

# Clean
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Xdebug
RUN if [ "$DOCKER_PHP_ENABLE_XDEBUG" = "on" ]; then \
    pecl install xdebug \
    && docker-php-ext-enable xdebug; \
    fi

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN groupadd --gid $gid $uname
RUN useradd -G www-data,root -s /bin/bash --uid $uid --gid $gid $uname

RUN mkdir -p /home/$uname/.composer && \
    chown -R $uname:$uname /home/$uname

WORKDIR /data/myapp.local

CMD composer i -o ;  php-fpm

EXPOSE 9000