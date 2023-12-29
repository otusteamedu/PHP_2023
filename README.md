### Реализация домашнего задания

`15 Redis`

В файле конфигурации `app/.env`
* значение параметра `USE_REPOSITORY`
указывает какое из предусмотренных хранилищ использовать,
данная версия поддерживает 
- `mongo` для MongoDB, используя дополнительно установленное расширение php
  `USE_REPOSITORY=mongo`
- `redis` для Redis, используя дополнительно установленное расширение php
  `USE_REPOSITORY=redis` 
- `predis` для Redis, используя установленный composer-пакет
  `USE_REPOSITORY=predis`

* параметр `QUEUE_UNIQUE` используется как уникальный ключ/БД
Если используемое хранилище используется еще для каких-то целей,
то снижается вероятность пересечения данных по этому ключу с существующими. 

* другие настройки для соединения с выбранным хранилищем(хост, порт).


- Собрать и запустить контейнеры
- Зайти в контейнер php-fpm
```shell
docker compose exec php-fpm-redis sh
```
- Установить composer-зависимости
```shell
composer install
```

Если все верно сделано, следующие шаги по заданию.

Примеры команд:
```shell
# загрузка событий из файла
php public/index.php init

# Поиск по параметрам (учитывается значение приоритета!)
php public/index.php get 1 2

# Добавление по элементно
php public/index.php add 1000 1 1 some-event-alias-1-1
php public/index.php add 2000 1 2 some-event-alias-1-2
php public/index.php add 3000 2 1 some-event-alias-2-1
php public/index.php add 4000 2 2 some-event-alias-2-2

# Очистка всех событий
php public/index.php clr
```
----
