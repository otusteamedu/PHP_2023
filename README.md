# PHP_2023

## Добавление событий:

`POST /events`

```json
{
    "events": [
        {
            "priority": 1000,
            "conditions": {
                "param1": 1
            },
            "event": {
                "name": "event_1",
                "type": "click",
                "dateTime": "2023-05-01 14:30:23"
            }
        },
        {
            "priority": 2000,
            "conditions": {
                "param1": 2,
                "param2": 2
            },
            "event": {
                "name": "event_2",
                "type": "click",
                "dateTime": "2023-05-01 14:30:23"
            }
        },
        {
            "priority": 3000,
            "conditions": {
                "param1": 1,
                "param2": 2
            },
            "event": {
                "name": "event_3",
                "type": "click",
                "dateTime": "2023-05-01 14:30:23"
            }
        }
    ]
}
```

## Поиск событий:

`GET /events/search`

```json
{
    "conditions": {
        "param1": 1,
        "param2": 2
    }
}
```

## Удаление событий:

`DELETE /events`
