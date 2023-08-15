# select-poster.sql

## Запрос:

```sql
EXPLAIN ANALYZE
    select distinct m.id as id, m."name"  from "session" AS s
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
|  movie  |10000|
| session | 1182|

```
QUERY PLAN                                                                                                                           |
-------------------------------------------------------------------------------------------------------------------------------------+
Unique  (cost=84.58..84.62 rows=6 width=37) (actual time=0.603..0.640 rows=100 loops=1)                                              |
  ->  Sort  (cost=84.58..84.59 rows=6 width=37) (actual time=0.602..0.609 rows=101 loops=1)                                          |
        Sort Key: m.id, m.name                                                                                                       |
        Sort Method: quicksort  Memory: 32kB                                                                                         |
        ->  Nested Loop Left Join  (cost=0.29..84.50 rows=6 width=37) (actual time=0.165..0.540 rows=101 loops=1)                    |
              ->  Seq Scan on session s  (cost=0.00..34.69 rows=6 width=16) (actual time=0.153..0.237 rows=101 loops=1)              |
                    Filter: (date(start_time) = CURRENT_DATE)                                                                        |
                    Rows Removed by Filter: 1081                                                                                     |
              ->  Index Scan using movie_pk on movie m  (cost=0.29..8.30 rows=1 width=37) (actual time=0.003..0.003 rows=1 loops=101)|
                    Index Cond: (id = s.movie_id)                                                                                    |
Planning Time: 0.218 ms                                                                                                              |
Execution Time: 0.700 ms                                                                                                             |
```

### 10000

После выполнения шага [02-10000](../02/descr.md#10000). Имеем:

| table   | count |
|---------|-------|
|  movie  |10000|
| session |13120|

Результат:
```
QUERY PLAN                                                                                                                     |
-------------------------------------------------------------------------------------------------------------------------------+
Unique  (cost=738.58..739.07 rows=66 width=37) (actual time=5.723..6.086 rows=880 loops=1)                                     |
  ->  Sort  (cost=738.58..738.74 rows=66 width=37) (actual time=5.722..5.796 rows=928 loops=1)                                 |
        Sort Key: m.id, m.name                                                                                                 |
        Sort Method: quicksort  Memory: 97kB                                                                                   |
        ->  Hash Right Join  (cost=380.43..736.59 rows=66 width=37) (actual time=2.753..5.432 rows=928 loops=1)                |
              Hash Cond: (m.id = s.movie_id)                                                                                   |
              ->  Seq Scan on movie m  (cost=0.00..243.00 rows=10000 width=37) (actual time=0.005..0.983 rows=10000 loops=1)   |
              ->  Hash  (cost=379.60..379.60 rows=66 width=16) (actual time=2.735..2.735 rows=928 loops=1)                     |
                    Buckets: 1024  Batches: 1  Memory Usage: 52kB                                                              |
                    ->  Seq Scan on session s  (cost=0.00..379.60 rows=66 width=16) (actual time=0.149..2.527 rows=928 loops=1)|
                          Filter: (date(start_time) = CURRENT_DATE)                                                            |
                          Rows Removed by Filter: 12192                                                                        |
Planning Time: 0.231 ms                                                                                                        |
Execution Time: 6.189 ms                                                                                                       |
```

### 10000000

Результат:
```
```