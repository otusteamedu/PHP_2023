FROM php:8-cli

WORKDIR /app

COPY . /app

# Install the sockets extension
RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install

CMD ["php", "app.php"]
