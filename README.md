# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Комментарий к домашнему заданию

В домашнем задании использутеся подключение к дувум базам данных MySQL (MariaDB):
- Docker-контейнер
- VM Homestead


### 1. Запуск docker-контейнеров
```bash
$ cp .env.example .env
$ docker compose up -d
```
### 2. Установка виртуальной машины Homestead

```bash
$ git clone https://github.com/laravel/homestead.git ./homestead
$ cd ./homestead/
$ git checkout release
$ bash init.sh
$ cp ../Homestead.yaml ./
$ vagrant up
```
### 3. Проверка работоспособности
**Проверка VM Homestead**

В браузере по адресу: http://application.local:8000/
Вывод функции phpinfo()

**Проверка Docker**

В браузере по адресу: http://application.local:8080/
Вывод:
- Версия Redis
- Версия Memcache
- MySQL соединение с Docker-контейнером (весия MariaDB)
- MySQL соединение с VM Homestead (весия MariaDB)
- Вывод функции phpinfo()
