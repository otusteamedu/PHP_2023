### Реализация домашнего задания

`30 Очереди. Часть 2`

В файле конфигурации `app/.env`
* значение параметра `USE_REPOSITORY`
указывает какое из предусмотренных хранилищ использовать,
данная версия поддерживает
- `rabbitmq` для RabbitMQ, используя установленный composer-пакет
  `USE_REPOSITORY=rabbitmq`

- `rabbit` для Rabbit, используя установленный composer-пакет.
Отличие между ключами `rabbitmq`/`rabbit`
- - в способе работы с очередями внутри хранилища
- - и в реализации получения сообщения из очереди
- - и в реализации оповещения через email или telegram
  `USE_REPOSITORY=rabbit`

- `redis` для Redis, используя установленное php-расширение
  `USE_REPOSITORY=redis`

- `kafka` для Kafka, используя установленное php-расширение
совместно с composer-пакетом 
  `USE_REPOSITORY=kafka`

* параметр `QUEUE_UNIQUE`
используется как уникальный ключ - наименования очереди
Если хранилище используется еще для каких-то целей,
то так вероятность пересечения данных по этому ключу ниже.

* другие настройки для соединения с выбранным хранилищем(хост, порт).


- Собрать и запустить контейнеры
```shell
cp ./.env.example ./.env
docker-compose up --build
```
- Зайти в контейнер php-fpm
```shell
docker compose exec rmq-php-fpm sh
```
- Установить composer-зависимости
```shell
composer install

docker exec -ti rmq-php-fpm composer install
```

Если все верно сделано, следующие шаги по заданию.

#### Добавление записи в очередь
```shell
curl --data 'start=2023-12-01&stop=2023-12-31&alias=qweqq&uid=3000&user[email]=to@box.ru&user[title]=Title-of-user&user[telegram]=telegramId' app.local
```

#### Чтение сообщений и оповещение
```shell
php -f public/index.php get all
```

Важно: в случае использования `USE_REPOSITORY=rabbit`
команда чтения и нотификации запускается для каждого типа нотификации отдельно
```shell
php -f public/index.php get email
```

```shell
php -f public/index.php get telegram
```

----
