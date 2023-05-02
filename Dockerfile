FROM php:8.2-cli

RUN apt-get update && \
    apt-get install -y git unzip && \
    docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY ./app/composer.json ./

RUN composer install --no-scripts --no-autoloader --no-dev

COPY ./app ./

RUN composer dump-autoload --optimize

CMD ["tail", "-f", "/dev/null"]
