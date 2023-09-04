FROM php:8-fpm

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
        libmemcached-dev \
        zlib1g-dev \
        libssl-dev \
        && pecl install mcrypt-1.0.6 \
	    && docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	    && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && pecl install memcached-3.2.0 \
        && docker-php-ext-enable memcached \
        && pecl install redis \
        && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# For restrict access to unix socket define same users
# in fpm and nginx containers and configure php-fpm to run processes under this user
RUN addgroup --gid 3000 --system safeapp
RUN adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 safeuser

COPY ./config/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# performs mkdir and cd implicitly
WORKDIR /data

# create unnamed volume in folder like /var/lib/docker/volumes/f670...49f0/_data on host machine
VOLUME /data

CMD ["php-fpm"]