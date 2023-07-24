FROM php:8.2-cli
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin
RUN docker-php-ext-install sockets
RUN docker-php-ext-enable sockets
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
RUN chown -R www-data:www-data /usr/src/myapp
CMD tail -f /dev/null