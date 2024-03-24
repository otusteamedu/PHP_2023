FROM php:8.1.22-fpm-alpine

#RUN docker-php-ext-install sockets

#RUN set -x \
#  && addgroup -g 101 -S nginx \
#  && adduser -u 101 -D -S -G nginx nginx

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install uploadprogress \
    && docker-php-ext-enable uploadprogress \
    && apk del .build-deps $PHPIZE_DEPS \
    && chmod uga+x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions bcmath \
            bz2 \
            calendar \
#            curl \
            exif \
#            fileinfo \
#            ftp \
            gd \
            gettext \
#            imagick \
            imap \
            intl \
            ldap \
#            mbstring \
            mcrypt \
            memcache \
            memcached \
#            mongodb \
            mysqli \
            opcache \
#            openssl \
#            pdo \
            pdo_pgsql \
            pdo_mysql \
#           pgsql \
            redis \
            soap \
#            sodium \
            sysvsem \
            sysvshm \
            xmlrpc \
            xsl \
            zip \
#    &&  echo -e "\n opcache.enable=1 \n opcache.enable_cli=1 \n opcache.memory_consumption=128 \n opcache.interned_strings_buffer=8 \n opcache.max_accelerated_files=4000 \n opcache.revalidate_freq=60 \n opcache.fast_shutdown=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
#    &&  echo -e "\n xdebug.remote_enable=1 \n xdebug.remote_host=localhost \n xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    &&  echo -e "\n xhprof.output_dir='/var/tmp/xhprof'" >> /usr/local/etc/php/conf.d/docker-php-ext-xhprof.ini \
    && cd ~ \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "copy('https://composer.github.io/installer.sig', 'signature');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === trim(file_get_contents('signature'))) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data/app.local