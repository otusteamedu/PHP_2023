# select-all-movie-today.sql

## Запрос:

```sql
EXPLAIN ANALYZE
    select s.movie_id, s.start_time::time, m."name"  from "session" AS s
    left join movie as m on s.movie_id=m.id
    where DATE(s.start_time) = CURRENT_DATE
```


### 10000

Результат:
```
```

### 10000000

Результат:
```
```