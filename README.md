# Проверка кода
```shell
docker-compose exec app vendor/bin/phpcs -h
```
## События
Реализовано хранение в redis или elasticsearch.

Для переключения в .env файле нужно изменить значение переменной EVENT_STORAGE на redis или elasticsearch.

## Запуск
```shell
docker-compose up -d
```

### Добавление событий
```shell
curl -X POST --location 'http://mysite.local/events/' \
--header 'Content-Type: application/json' \
--data '{
    "priority": 1000,
    "conditions": {
      "param1": 1
    },
    "event": ["::event::"]
}' && \
curl -X POST --location 'http://mysite.local/events/' \
--header 'Content-Type: application/json' \
--data '{
    "priority": 2000,
    "conditions": {
      "param1": 2,
      "param2": 2
    },
    "event": ["::event::"]
}' && \
curl -X POST --location 'http://mysite.local/events/' \
--header 'Content-Type: application/json' \
--data '{
    "priority": 3000,
    "conditions": {
      "param1": 1,
      "param2": 2
    },
    "event": ["::event::"]
}'
```

### Получение событий
```shell
curl --location 'http://mysite.local/events/?param1=1&param2=2' -H 'Content-Type: application/json'
```

## Очистка событий
```shell
curl --request POST -H 'Content-Type: application/json' 'http://mysite.local/events/clear/'
```
