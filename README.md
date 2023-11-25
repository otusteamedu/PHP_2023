# Вэб окружение для dev стенда

1. Переименовать `.env.example` в `.env`
2. Обязательно задать свой домен в `.env`
3. Обязательно задать свой volume в `.env` для бд и сокета

После этого, можно запускать окружение.

Важно:

Контейнеры для `php-fpm` и `composer` лежат в отдельном профиле и вызываются когда нужно

```bash
docker compose run --rm php-cli php index.php
```
или например для инициализации composer

```bash
docker compose run --rm composer composer init
```