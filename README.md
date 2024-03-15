# ДЗ Работа с очередью

## Использование

Задаем переменные окружения _**.env**_.
Пример в _**.env.example**_

В **hosts** добавить запись **127.0.0.1 mysite.local**

Далее:

```bash
docker compose up -d
docker exec -it php-fpm bash
composer install
```

Здесь же запустить Consumer:

```bash
cd public
php index.php
```

В Consumer будут приходить сообщения.

Отправка сообщений:

```bash
curl --request POST \
  --url http://mysite.local/ \
  --header 'content-type: multipart/form-data' \
  --form 'msg=Hello'
```