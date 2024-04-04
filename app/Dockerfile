# Используем официальный образ PHP с FPM
FROM php:8.2-fpm

# Установка необходимых расширений PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем рабочую директорию приложения
WORKDIR /var/www

# Копируем файлы приложения в рабочую директорию
COPY ./www /var/www

# Устанавливаем зависимости Composer
RUN composer install --no-plugins --no-interaction

# Указываем порт, на котором будет работать приложение (если необходимо)
EXPOSE 9000

# Опционально: команда по умолчанию, которая будет выполнена при запуске контейнера
CMD ["php-fpm"]
