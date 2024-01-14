# API
## Запуск
Для запуска необходимо выполнить команду:
```bash
docker-compose up

# Войти в контейнер
docker compose exec app bash

## Запуск консьюмера
./bin/console.php messenger:consume rabbit

## Дебаг cli-команд
Для дебага cli-команд необходимо выполнить команду:
```bash
export XDEBUG_MODE=debug && XDEBUG_CONFIG="idekey=PHPSTORM" && export XDEBUG_SESSION=1 && php -f ./bin/console.php
```
