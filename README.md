### Инициализация проекта
1. Выполните 
```bash
    docker-compose up --build -d
    docker exec -it php-server bash 
    composer i
```
2. Добавьте /etc/hosts -> mysite.local

---

### Описания 
- Возможно выбрать между использованием Redis и MongoDB. (по умолчанию Redis)
  1. Перейти в ./app/
  2. В файле .env -> установить нужную конфигурацию.

- Создание события - POST /api/events
  ```json
    {
        "priority": 1000,
        "conditions": {
            "param1": 1,
            "param2": 2
        },
        "event": "event1"
    }
  ```

  Пример:

  ```bash
    curl -X POST http://mysite.local/api/events -H 'Content-Type: application/json' -d '{"priority":1000, "conditions":{"param1": 1, "param2": 2}, "event": "event1"}'
  ```

- Посмотреть все добавленные события - GET /api/events

  Пример:

  ```bash
    curl -X GET http://mysite.local/api/events
  ```

- Удалить событие - DELETE /api/events/{key}

Пример:

  ```bash
    curl -X DELETE http://mysite.local/api/events/'{key}'
  ```

---

### Пример использования
- Добовляем события 

```bash
    curl -X POST http://mysite.local/api/events -H 'Content-Type: application/json' -d '{"priority":1000, "conditions":{"param1": 1, "param2": 2}, "event": "event1"}'

    curl -X POST http://mysite.local/api/events -H 'Content-Type: application/json' -d '{"priority":2000, "conditions":{"param1": 1, "param2": 3}, "event": "event2"}'

    curl -X POST http://mysite.local/api/events -H 'Content-Type: application/json' -d '{"priority":3000, "conditions":{"param1": 1, "param2": 3}, "event": "event3"}'
```

- Делаем запросы: 
   
  ```bash
      curl -X GET 'http://mysite.local?param1=1'
  ```
  **Результат:** *Нет подходящих событий.*
   
  ```bash
      curl -X GET 'http://mysite.local?param1=1&param2=2'
  ```
  **Результат:** *Вам доступно событие: event1*
  
  ```bash
      curl -X GET 'http://mysite.local?param1=1&param2=3'
  ```
  **Результат:** *Вам доступно событие: event3*



