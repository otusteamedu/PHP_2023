FROM php:fpm

RUN apt-get update \
	&& apt-get install -y libmemcached-dev libssl-dev zlib1g-dev \
	&& pecl install redis \
	&& pecl install memcached-3.2.0 \
	&& docker-php-ext-enable redis memcached \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-enable mysqli \
    && apt-get install -y git \
    && apt-get install -y locales \
    && sed -i -e \
         's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen \
    && locale-gen

ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU:ru
ENV LC_LANG ru_RU.UTF-8
ENV LC_ALL ru_RU.UTF-8

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
