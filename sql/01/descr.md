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

| table   | count |
|---------|-------|
| movie   | 10000 |
| session | 1182  |

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
| movie   | 10000 |
| session | 13120 |

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

Добавим записей в таблицу `movie` выполнением `docker/postrgesql-initdb.d/71-insert-movie.sql`  
Добавим записей в таблицу `session` выполнением:

```sql
INSERT INTO public."session" (hall_id, movie_id, start_time, length_minute)
    select uuid_generate_v4() as hall_id, uuid_generate_v4() as movie_id, 
        timestamp '2023-01-01 08:00:00' + random() * (timestamp '2023-08-30 20:00:00' - timestamp '2023-01-01 08:00:00') as start_time, 
        floor(random() * 2000 + 30)::int as length_minute
    FROM generate_series(1, 10000000);
```

| table   | count |
|---------|-------|
| movie   |10010000|
| session |10013306|

Результат:
```
QUERY PLAN                                                                                                                            |
--------------------------------------------------------------------------------------------------------------------------------------+
Gather  (cost=1000.43..362803.88 rows=49933 width=45) (actual time=7.128..664.668 rows=42297 loops=1)                                 |
  Workers Planned: 2                                                                                                                  |
  Workers Launched: 2                                                                                                                 |
  ->  Nested Loop Left Join  (cost=0.43..356810.58 rows=20805 width=45) (actual time=6.907..641.448 rows=14099 loops=3)               |
        ->  Parallel Seq Scan on session s  (cost=0.00..221160.16 rows=20805 width=24) (actual time=6.854..556.396 rows=14099 loops=3)|
              Filter: (date(start_time) = CURRENT_DATE)                                                                               |
              Rows Removed by Filter: 3323670                                                                                         |
        ->  Index Scan using movie_pk on movie m  (cost=0.43..6.52 rows=1 width=37) (actual time=0.006..0.006 rows=0 loops=42297)     |
              Index Cond: (id = s.movie_id)                                                                                           |
Planning Time: 1.019 ms                                                                                                               |
JIT:                                                                                                                                  |
  Functions: 24                                                                                                                       |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                       |
  Timing: Generation 1.852 ms, Inlining 0.000 ms, Optimization 1.147 ms, Emission 19.106 ms, Total 22.105 ms                          |
Execution Time: 668.397 ms                                                                                                            |
```

### Оптимизация

Изначально все таблицы имеют индекс только по первичному ключу (поле `id`).

Добавим индекс 
```sql
CREATE INDEX session_start_time_idx ON public."session" (start_time);
```

Результат:
```
QUERY PLAN                                                                                                                            |
--------------------------------------------------------------------------------------------------------------------------------------+
Gather  (cost=1000.43..363299.96 rows=50067 width=45) (actual time=6.332..656.748 rows=42297 loops=1)                                 |
  Workers Planned: 2                                                                                                                  |
  Workers Launched: 2                                                                                                                 |
  ->  Nested Loop Left Join  (cost=0.43..357293.26 rows=20861 width=45) (actual time=6.471..636.800 rows=14099 loops=3)               |
        ->  Parallel Seq Scan on session s  (cost=0.00..221354.69 rows=20861 width=24) (actual time=6.425..563.315 rows=14099 loops=3)|
              Filter: (date(start_time) = CURRENT_DATE)                                                                               |
              Rows Removed by Filter: 3323670                                                                                         |
        ->  Index Scan using movie_pk on movie m  (cost=0.43..6.51 rows=1 width=37) (actual time=0.005..0.005 rows=0 loops=42297)     |
              Index Cond: (id = s.movie_id)                                                                                           |
Planning Time: 0.340 ms                                                                                                               |
JIT:                                                                                                                                  |
  Functions: 24                                                                                                                       |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                       |
  Timing: Generation 1.730 ms, Inlining 0.000 ms, Optimization 1.294 ms, Emission 17.810 ms, Total 20.834 ms                          |
Execution Time: 660.313 ms                                                                                                            |
```

Изменим запрос на
```sql
EXPLAIN ANALYZE
    select s.movie_id, s.start_time::time, m."name"  from "session" AS s
    left join movie as m on s.movie_id=m.id
    where s.start_time >= current_date + '00:00:00'::time and s.start_time < current_date + '24:00:00'::time 
```

Результат без индекса:
```
QUERY PLAN                                                                                                                                                        |
------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Gather  (cost=1000.43..380848.00 rows=44052 width=45) (actual time=6.307..589.961 rows=42297 loops=1)                                                             |
  Workers Planned: 2                                                                                                                                              |
  Workers Launched: 2                                                                                                                                             |
  ->  Nested Loop Left Join  (cost=0.43..375442.80 rows=18355 width=45) (actual time=6.702..570.169 rows=14099 loops=3)                                           |
        ->  Parallel Seq Scan on session s  (cost=0.00..252646.27 rows=18355 width=24) (actual time=6.659..496.546 rows=14099 loops=3)                            |
              Filter: ((start_time >= (CURRENT_DATE + '00:00:00'::time without time zone)) AND (start_time < (CURRENT_DATE + '24:00:00'::time without time zone)))|
              Rows Removed by Filter: 3323670                                                                                                                     |
        ->  Index Scan using movie_pk on movie m  (cost=0.43..6.69 rows=1 width=37) (actual time=0.005..0.005 rows=0 loops=42297)                                 |
              Index Cond: (id = s.movie_id)                                                                                                                       |
Planning Time: 0.341 ms                                                                                                                                           |
JIT:                                                                                                                                                              |
  Functions: 24                                                                                                                                                   |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                   |
  Timing: Generation 1.991 ms, Inlining 0.000 ms, Optimization 0.977 ms, Emission 18.863 ms, Total 21.831 ms                                                      |
Execution Time: 593.778 ms                                                                                                                                        |
```

Результат с индексом `session_start_time_idx`:
```
QUERY PLAN                                                                                                                                                                  |
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Gather  (cost=1936.41..224510.87 rows=44052 width=45) (actual time=25.430..146.888 rows=42297 loops=1)                                                                      |
  Workers Planned: 2                                                                                                                                                        |
  Workers Launched: 2                                                                                                                                                       |
  ->  Nested Loop Left Join  (cost=936.41..219105.67 rows=18355 width=45) (actual time=18.119..126.976 rows=14099 loops=3)                                                  |
        ->  Parallel Bitmap Heap Scan on session s  (cost=935.98..96309.15 rows=18355 width=24) (actual time=13.001..53.481 rows=14099 loops=3)                             |
              Recheck Cond: ((start_time >= (CURRENT_DATE + '00:00:00'::time without time zone)) AND (start_time < (CURRENT_DATE + '24:00:00'::time without time zone)))    |
              Heap Blocks: exact=12619                                                                                                                                      |
              ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..924.96 rows=44052 width=0) (actual time=14.647..14.647 rows=42297 loops=1)                       |
                    Index Cond: ((start_time >= (CURRENT_DATE + '00:00:00'::time without time zone)) AND (start_time < (CURRENT_DATE + '24:00:00'::time without time zone)))|
        ->  Index Scan using movie_pk on movie m  (cost=0.43..6.69 rows=1 width=37) (actual time=0.004..0.004 rows=0 loops=42297)                                           |
              Index Cond: (id = s.movie_id)                                                                                                                                 |
Planning Time: 0.384 ms                                                                                                                                                     |
JIT:                                                                                                                                                                        |
  Functions: 30                                                                                                                                                             |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                             |
  Timing: Generation 2.418 ms, Inlining 0.000 ms, Optimization 1.050 ms, Emission 20.995 ms, Total 24.463 ms                                                                |
Execution Time: 150.312 ms                                                                                                                                                  |
```

Используется индекс, ускорение в 4 раза.