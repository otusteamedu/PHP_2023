# Используем образ PHP с Apache
FROM php:8.1-apache

# Устанавливаем необходимые утилиты для установки расширений PHP, MySQLi и zip
RUN apt-get update \
    && apt-get install -y libzip-dev zip libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

# Включаем модуль Apache Rewrite для обработки правил перезаписи
RUN a2enmod rewrite
