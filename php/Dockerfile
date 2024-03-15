FROM php:8.2-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
  curl \
  wget \
  git \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libonig-dev \
  libzip-dev \
  libpq-dev \
  libmcrypt-dev \
  && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
  && docker-php-ext-configure sockets \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install redis-5.3.7 \
  && pecl install xdebug-3.2.1 \
  && docker-php-ext-enable redis xdebug

WORKDIR /data/mysite.local

CMD ["php-fpm"]