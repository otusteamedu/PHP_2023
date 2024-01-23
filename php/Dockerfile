FROM php:8.1-cli

RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libzip-dev && \
    docker-php-ext-install zip pdo pdo_mysql && \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . /app

CMD ["tail", "-f", "/dev/null"]
