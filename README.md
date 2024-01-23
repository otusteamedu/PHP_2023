# Описание работы

Реализованы следующие паттерны: TableGateway, RowGateway, DataMapper (c IdentityMap), ActiveRecord. Для паттерна TableGateway реализован
API.

## Использование API

```bash
docker compose up -d
composer install

В папке ddl выполнить create_tables.sql, init.sql

Добавить mysite.local в список локальных хостов
```

### Примеры:

1. Вывод всех жанров

```bash
GET http://mysite.local/tableGateway/genres
||
GET http://mysite.local/dataMapper/genres
```

2. Вывод конкретного жанра

```bash
GET http://mysite.local/tableGateway/genres?id=1
||
GET http://mysite.local/dataMapper/genres?id=1
```

3. Добавление жанра

```bash
POST http://mysite.local/tableGateway/genres
||
POST http://mysite.local/dataMapper/genres

Тело запроса:
{
    "title": "Боевик"
}
```

4. Изменение жанра

```bash
PUT http://mysite.local/tableGateway/genres
||
PUT http://mysite.local/dataMapper/genres

Тело запроса:
{
    "id": 1,
    "title": "Боевик"
}
```

5. Удаление жанра

```bash
DELETE http://mysite.local/tableGateway/genres

Тело запроса:
{
    "id": 1
}
```

6. Вывод всех фильмов

```bash
GET http://mysite.local/tableGateway/movies
```

7. Вывод конкретного фильма

```bash
GET http://mysite.local/tableGateway/movies?id=1
```

8. Добавление фильма

```bash
POST http://mysite.local/tableGateway/movies

Тело запроса:
{
    "title": "Рэмбо",
    "genre_id": 1,
    "duration": 150,
    "rating": 3
}
```

9. Изменение фильма

```bash
PUT http://mysite.local/tableGateway/movies

Тело запроса:
{
    "id": 2,
    "title": "Рэмбо",
    "genre_id": 1,
    "duration": 150,
    "rating": 3
}
```

10. Удаление фильма

```bash
DELETE http://mysite.local/tableGateway/movies

Тело запроса:
{
    "id": 1
}
```