# Используйте официальный образ PHP 8.2 FPM
FROM php:8.2-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочей директории
WORKDIR /data

VOLUME /data

# Копирование вашего приложения в контейнер (предполагается, что ваш код находится в текущей директории)
COPY . /data

# Выставление прав на директорию
RUN chown -R www-data:www-data /var/www

# Открытие порта 9000
EXPOSE 9000

# Запуск PHP-FPM
CMD ["php-fpm"]
