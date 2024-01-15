# API
# Нужно создать файл .env и прописать в нем переменные окружения. Пример .env.example.

## Запуск
Для запуска необходимо выполнить команду:
```bash
docker-compose up

# Войти в контейнер
docker compose exec app bash

## установка composer пакетов
composer install 

## Запуск консьюмера
./bin/console.php messenger:consume rabbit
```
Теперь можно в браузере открыть http://localhost
Там будет форма для отправки запроса на создание заказа. Нужно указать email и указать период от, до. Важно помнить что период должен быть больше либо равен 24 часа.
Если все ок, то в ответе будет сказано: "Заказ успешно добавлен в очередь". Если нет, то будет ошибка.
В проекте две очереди: 1. Запросы на обработку заказов. 2. Отправка писем.
