# HW09

## Запуск
1. Запуск контейнеров: `docker-compose up -d`
1. Установка зависимостей: `docker-compose exec php composer install`
1. Запуск сервера: `docker-compose exec php php ./public/index.php server`
1. Запуск клиента: `docker-compose exec php php ./public/index.php client`
1. Запуск с конфигурационным файлом: `docker-compose exec php php ./public/index.php -c ./public/config.ini server` или `docker-compose exec php php ./public/index.php -c ./public/config.ini client` 
