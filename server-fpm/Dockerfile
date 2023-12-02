FROM php:8.2-cli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN docker-php-ext-install sockets

WORKDIR /usr/src/myapp

CMD [ "php", "./code/index.php", "server" ]
