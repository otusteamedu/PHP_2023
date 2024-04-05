FROM php:8.1-apache

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

RUN apt-get update
RUN apt-get install -y git vim

RUN curl -s https://getcomposer.org/installer | php

RUN chmod +x composer.phar
RUN mv composer.phar /usr/local/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv ~/.symfony5/bin/symfony /usr/local/bin/symfony
WORKDIR /var/www/html
