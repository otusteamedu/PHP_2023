### Реализация домашнего задания

* `console chat`

Консольный чат на сокетах

Инструкция по установке, настройки и использованию консольного сетевого чата.

-- --
#### Настройка

* создание файла конфигурации для запуска docker-контейнеров
```shell
cp ./.env.example ./.env
```

* создание файла конфигурации для использования консольного сетевого чата
```shell
cp ./src/config.ini.example ./src/config.ini
```

* Собрать и запустить docker-контейнеры
```shell
docker-compose up --build
```

* установка composer-зависимостей
```shell
  docker exec -ti php-fpm-chat-server composer install
```
-- --
#### Запуск
Запуск серверного функционала приложения
```shell
docker exec -ti php-fpm-chat-server php public/app.php server
```

Запуск клиента консольного чата
```shell
docker exec -ti php-fpm-chat-client php public/app.php client
```

Запуск дополнительного клиента консольного чата
```shell
docker exec -ti php-fpm-chat-client-second php public/app.php client
```

Теперь приложение готово к использованию.
-- --
#### Использование

В приложении клиента ожидается ввод текста, автоматическая отправка на сервер и получение подтверждения от сервера.

В консоли выводятся сообщения на серверной и клиентских сторонах.

-- --
