# Email verification домашняя работа 5

Проверка корректности email и проверка MX записи у домена к которому принадлежит данная почта.

## Как запустить?

```bash
docker-compose up -d
```

```bash
docker container run --rm -v ./:/var/www/html php:8.2-cli php /var/www/html/index.php
```