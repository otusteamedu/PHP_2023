# PHP CLI сервис

Находится в общем конфиге - docker compose
Служит для запуска скриптов или сервисов (например composer)

Имеет довольно лаконичную команду для запуска.

Пример запустить файл index.php в корне проекта:

Если `tty = true`, используй

```bash
docker compose exec php-cli php index.php
```

Если `tty = false`, используй

```bash
docker compose run --rm php-cli php index.php
```

# Все сервисы

```bash
docker-compose up
```

Запустит все сервисы