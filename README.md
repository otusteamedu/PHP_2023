# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Homework 15

For init app run in console:

```bash
docker-compose up
```

### Routes:

- GET /films -  List of films
- GET /films?film_id - Get film by id
- POST /films - create film
- POST /films?film_id - update film
- DELETE /films?film_id - delete film


1. Старая версия приложения находится в папке app_old
2. переделал приложение в соответствии с подходом чистой архитектуры.
3. Добавил слои приложения
4. поключил DI
5. реализовал зависисммости от нижних слоев к верхним