# HW09

## Запуск в одном контейнере
1. Запуск контейнеров: `docker-compose up -d`
1. Установка зависимостей: `docker-compose exec php composer install`
1. Запуск сервера: `docker-compose exec php php ./public/index.php server`
1. Запуск клиента: `docker-compose exec php php ./public/index.php client`
1. Запуск с конфигурационным файлом: `docker-compose exec php php ./public/index.php -c ./public/config.ini server`

## Запуск в разных контейнерах
1. Запуск контейнера сервера: `docker-compose up -d server`
1. Запуск контейнера клиента: `docker-compose up -d client`
1. Установка зависимостей: `docker-compose exec server composer install`
1. Запуск сервера: `docker-compose exec server php ./public/index.php server`
1. Запуск клиента: `docker-compose exec client php ./public/index.php client`

## Описание.
Сервер запускается перед клиентом.

После запуска сервер и клиент ожидают пользовательского ввода, после ввода строки и нажатия 
`Enter` строка будет отправлена другой стороне.

Для выхода ввести `:q` и нажать `Enter`. 
