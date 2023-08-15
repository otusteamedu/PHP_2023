# select-all-movie-today.sql

## Запрос:

```sql
EXPLAIN ANALYZE
    select s.movie_id, s.start_time::time, m."name"  from "session" AS s
    left join movie as m on s.movie_id=m.id
    where DATE(s.start_time) = CURRENT_DATE
```

Количество записей в таблицах

```sql
select 'movie' as table, count(id) from "movie"
union
select 'session' as table, count(id) from "session"
```

| table  | count |
| ------- |-------|
| movie  | 10000 |
| session| 1182  |

```
QUERY PLAN                                                                                                               |
-------------------------------------------------------------------------------------------------------------------------+
Nested Loop Left Join  (cost=0.29..84.52 rows=6 width=45) (actual time=0.244..1.152 rows=101 loops=1)                    |
    ->  Seq Scan on session s  (cost=0.00..34.69 rows=6 width=24) (actual time=0.220..0.331 rows=101 loops=1)              |
        Filter: (date(start_time) = CURRENT_DATE)                                                                        |
        Rows Removed by Filter: 1081                                                                                     |
    ->  Index Scan using movie_pk on movie m  (cost=0.29..8.30 rows=1 width=37) (actual time=0.007..0.007 rows=1 loops=101)|
        Index Cond: (id = s.movie_id)                                                                                    |
Planning Time: 1.290 ms                                                                                                  |
Execution Time: 1.214 ms                                                                                                 |
```

### 10000

Добавим записей в таблицу `session` выполнением `docker/postrgesql-initdb.d/73-insert-sessions.sql`

| table   | count |
|---------|-------|
|  movie  |10000|
| session |13120|

Результат:
```
QUERY PLAN                                                                                                         |
-------------------------------------------------------------------------------------------------------------------+
Hash Right Join  (cost=380.43..736.75 rows=66 width=45) (actual time=2.921..5.649 rows=928 loops=1)                |
  Hash Cond: (m.id = s.movie_id)                                                                                   |
  ->  Seq Scan on movie m  (cost=0.00..243.00 rows=10000 width=37) (actual time=0.004..0.963 rows=10000 loops=1)   |
  ->  Hash  (cost=379.60..379.60 rows=66 width=24) (actual time=2.904..2.905 rows=928 loops=1)                     |
        Buckets: 1024  Batches: 1  Memory Usage: 59kB                                                              |
        ->  Seq Scan on session s  (cost=0.00..379.60 rows=66 width=24) (actual time=0.174..2.681 rows=928 loops=1)|
              Filter: (date(start_time) = CURRENT_DATE)                                                            |
              Rows Removed by Filter: 12192                                                                        |
Planning Time: 0.326 ms                                                                                            |
Execution Time: 5.738 ms                                                                                           |
```

### 10000000

Результат:
```
```