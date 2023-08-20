# PHP_2023

## Запуск
1. `docker-compose build php`
2. `docker-compose up`

## Пример тела запроса
```json
{
  "type": "get_bank_statement",
  "dateStart": "2000-01-01",
  "dateEnd": "2030-01-01",
  "notification": {
    "email": "email@email.email",
    "telegram": "telegram_name"
  }
}
```

## Пример запроса
```shell
curl --request GET '192.168.56.151' --header 'Content-Type: application/json' --data-raw '{
    "type": "get_bank_statement",
    "dateStart": "2000-01-01",
    "dateEnd": "2030-01-01",
    "notification": {
        "email": "email@email.email",
        "telegram": "telegram_name"
    }
}'
```
