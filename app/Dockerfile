FROM php:8.2-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN mkdir /data && \
    mkdir /data/default && \
    chown -R www-data:www-data /data && \
    curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && \
    apt-get update -y &&  \
    apt-get -y install gcc make autoconf libc-dev pkg-config libzip-dev zip unzip &&  \
    apt-get install -y --no-install-recommends \
	git

RUN apt-get install -y libpq-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip

RUN apt-get update && apt-get install -y locales

# Locale
RUN sed -i -e \
  's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen \
   && locale-gen

ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU:ru
ENV LC_LANG ru_RU.UTF-8
ENV LC_ALL ru_RU.UTF-8

# +Timezone (если надо на этапе сборки)
ENV TZ Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /data

# USER www-data
CMD ["php-fpm"]
