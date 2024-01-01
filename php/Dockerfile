# Используем официальный образ PHP CLI
FROM php:8.1-cli

# Установка зависимостей, включая расширения для PHP и unzip
RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libzip-dev && \
    docker-php-ext-install zip pdo pdo_mysql && \
    rm -rf /var/lib/apt/lists/*

# Устанавливаем Composer для управления зависимостями PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Указываем рабочую директорию для PHP
WORKDIR /usr/src/myapp

# Копируем исходный код PHP-приложения в контейнер
COPY . /usr/src/myapp

# Запускаем команду, которая не завершится
CMD ["tail", "-f", "/dev/null"]
