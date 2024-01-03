# API
## Запуск
Для запуска необходимо выполнить команду:
```bash
docker-compose up

# Войти в контейнер
docker compose exec app bash
# Создать базу данных
php -f ./bin/console.php orm:schema-tool:drop --force && php -f ./bin/console.php orm:schema-tool:create

# Заполнить базу данных
## Войти в контейнер db  
psql -d default -U postgres -f ./0_tables.sql && \
psql -d default -U postgres -f ./1_regions.sql && \
psql -d default -U postgres -f ./2_countries.sql && \
psql -d default -U postgres -f ./3_states.sql && \
psql -d default -U postgres -f ./4_cities.sql


# Заполнить базу данных
php -f ./bin/console.php migrate

```
## OpenAPI
Для генерации OpenAPI необходимо выполнить команду:
```bash
docker compose exec app bash
./vendor/bin/openapi
```

## Дебаг cli-команд
Для дебага cli-команд необходимо выполнить команду:
```bash
export XDEBUG_MODE=debug && XDEBUG_CONFIG="idekey=PHPSTORM" && export XDEBUG_SESSION=1 && php -f ./bin/console.php
```
