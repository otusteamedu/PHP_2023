FROM php:8.1

RUN apt-get update && apt-get install -y \
    procps \
	libzip-dev \
	libmcrypt-dev \
    zip \
    unzip \
    locales \
    git \
    curl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && pecl install redis \
    && docker-php-ext-enable redis.so \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    \
    && set -x \
    && deluser www-data \
    && groupadd --gid 1000 www-data \
    && useradd --gid 1000 www-data

RUN sed -i -e \
  's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen \
   && locale-gen

ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU:ru
ENV LC_LANG ru_RU.UTF-8
ENV LC_ALL ru_RU.UTF-8

WORKDIR /data/application

RUN chown -R www-data:www-data /data

USER www-data

CMD ["tail", "-f", "/dev/null"]
