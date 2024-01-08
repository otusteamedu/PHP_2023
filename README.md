### Реализация домашнего задания

`31 Проектирование API`

В файле конфигурации `app/.env`
* значение параметра `USE_REPOSITORY`
указывает какое из предусмотренных хранилищ использовать,
данная версия поддерживает
- `rabbitmq` для RabbitMQ (очереди), используя установленный composer-пакет
  `USE_REPOSITORY=rabbitmq`

* значение параметра `USE_STORAGE`
- `redis` для Redis (хранилище статусов), используя установленное php-расширение
  `USE_STORAGE=redis`

* параметр `QUEUE_UNIQUE`
используется как уникальный ключ - наименования очереди
Если хранилище используется еще для каких-то целей,
то так вероятность пересечения данных по этому ключу ниже.

* параметр `APP_MODE`, значения `prod`, и отличное - пример `dev`
Имеет значение при организации чтения сообщений из очереди.
- - Значение `prod` применяется для продакшн версии,
- - иное значение, например `dev` - применяется для авто-тестирования
  `APP_MODE=dev`

* параметр `QA_PAUSE_IN_WATCH_QUEUE`,
значение определяет паузу при обработке сообщений очереди
применяется при авто-тестировании обновления статуса сообщения очереди
  `QA_PAUSE_IN_WATCH_QUEUE=4`

* параметр `NGINX_DOCKER_HOST`, определяет имя хоста для авто-тестирования
  `NGINX_DOCKER_HOST=api-nginx`
 
* другие настройки для соединения с выбранным хранилищем(хост, порт).


- Собрать и запустить контейнеры
```shell
cp ./.env.example ./.env
docker compose build
```
- Зайти в контейнер php-fpm (одной из команд)
```shell
docker exec -ti api-php-fpm sh
docker compose exec api-php-fpm sh
```
- Установить composer-зависимости
```shell
composer install
```

Для подтверждения корректности настройки и установки добавлены авто-тесты
```shell
docker exec -ti api-php-fpm vendor/phpunit/phpunit/phpunit tests
```

Ожидаемое успешное выполнение
```shell
PHPUnit 9.6.15 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 00:08.092, Memory: 6.00 MB

OK (1 test, 23 assertions)
```


Следующие шаги по заданию.

### Post-запрос - добавление в очередь 
```shell
curl --data 'info=inf&uuid=1234' app.local/add
```
Ожидаемый вывод
```json
 {"success":true,"data":{"message":"Your request with be processed","uuid":"1234"}}
```



### Get-запрос - получение статуса обработки запроса 
```shell
curl 'localhost:8088/status?uuid=1234
```
Ожидаемый вывод
```json
 {"success":true,"data":{"status":"start","uuid":"1234"}}
```
```json
 {"success":true,"data":{"status":"complete","uuid":"1234"}}
```
----
