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
| movie   | 10000 |
| session | 1182  |

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
| movie   | 10000 |
| session | 13120 |

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

Записи были добавлены ранее. Имеем:

| table   | count |
|---------|-------|
|  movie  |10010000|
| session |10013306|

Результат:
```
QUERY PLAN                                                                                                                                        |
--------------------------------------------------------------------------------------------------------------------------------------------------+
Unique  (cost=359250.79..365315.97 rows=49933 width=37) (actual time=5808.801..5822.627 rows=881 loops=1)                                         |
  ->  Gather Merge  (cost=359250.79..365066.31 rows=49933 width=37) (actual time=5808.800..5818.976 rows=42297 loops=1)                           |
        Workers Planned: 2                                                                                                                        |
        Workers Launched: 2                                                                                                                       |
        ->  Sort  (cost=358250.77..358302.78 rows=20805 width=37) (actual time=5791.101..5791.850 rows=14099 loops=3)                             |
              Sort Key: m.id, m.name                                                                                                              |
              Sort Method: quicksort  Memory: 969kB                                                                                               |
              Worker 0:  Sort Method: quicksort  Memory: 934kB                                                                                    |
              Worker 1:  Sort Method: quicksort  Memory: 938kB                                                                                    |
              ->  Nested Loop Left Join  (cost=0.43..356758.56 rows=20805 width=37) (actual time=9.556..5782.231 rows=14099 loops=3)              |
                    ->  Parallel Seq Scan on session s  (cost=0.00..221160.16 rows=20805 width=16) (actual time=7.881..414.117 rows=14099 loops=3)|
                          Filter: (date(start_time) = CURRENT_DATE)                                                                               |
                          Rows Removed by Filter: 3323670                                                                                         |
                    ->  Index Scan using movie_pk on movie m  (cost=0.43..6.52 rows=1 width=37) (actual time=0.380..0.380 rows=0 loops=42297)     |
                          Index Cond: (id = s.movie_id)                                                                                           |
Planning Time: 6.770 ms                                                                                                                           |
JIT:                                                                                                                                              |
  Functions: 22                                                                                                                                   |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                   |
  Timing: Generation 2.489 ms, Inlining 0.000 ms, Optimization 1.900 ms, Emission 21.370 ms, Total 25.759 ms                                      |
Execution Time: 5823.238 ms                                                                                                                       |
```

### Оптимизация

Индекс `session_start_time_idx` был добавлен ранее.
Результат:
```
QUERY PLAN                                                                                                                                        |
--------------------------------------------------------------------------------------------------------------------------------------------------+
Unique  (cost=359737.76..365819.22 rows=50067 width=37) (actual time=641.499..656.480 rows=881 loops=1)                                           |
  ->  Gather Merge  (cost=359737.76..365568.88 rows=50067 width=37) (actual time=641.499..653.014 rows=42297 loops=1)                             |
        Workers Planned: 2                                                                                                                        |
        Workers Launched: 2                                                                                                                       |
        ->  Sort  (cost=358737.73..358789.89 rows=20861 width=37) (actual time=629.239..629.903 rows=14099 loops=3)                               |
              Sort Key: m.id, m.name                                                                                                              |
              Sort Method: quicksort  Memory: 977kB                                                                                               |
              Worker 0:  Sort Method: quicksort  Memory: 914kB                                                                                    |
              Worker 1:  Sort Method: quicksort  Memory: 950kB                                                                                    |
              ->  Nested Loop Left Join  (cost=0.43..357241.11 rows=20861 width=37) (actual time=5.228..625.285 rows=14099 loops=3)               |
                    ->  Parallel Seq Scan on session s  (cost=0.00..221354.69 rows=20861 width=16) (actual time=5.189..549.880 rows=14099 loops=3)|
                          Filter: (date(start_time) = CURRENT_DATE)                                                                               |
                          Rows Removed by Filter: 3323670                                                                                         |
                    ->  Index Scan using movie_pk on movie m  (cost=0.43..6.51 rows=1 width=37) (actual time=0.005..0.005 rows=0 loops=42297)     |
                          Index Cond: (id = s.movie_id)                                                                                           |
Planning Time: 0.281 ms                                                                                                                           |
JIT:                                                                                                                                              |
  Functions: 22                                                                                                                                   |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                   |
  Timing: Generation 1.633 ms, Inlining 0.000 ms, Optimization 0.753 ms, Emission 14.708 ms, Total 17.094 ms                                      |
Execution Time: 657.187 ms                                                                                                                        |                                                                                                                           |                                                                                                         |
```

Изменим условие:
```sql
EXPLAIN ANALYZE
select distinct m.id as id, m."name"  from "session" AS s
                                               left join movie as m on s.movie_id=m.id
where s.start_time >= current_date + '00:00:00'::time and s.start_time < current_date + '24:00:00'::time 
```

Результат:
```
QUERY PLAN                                                                                                                                                                              |
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
HashAggregate  (cost=224189.66..224556.76 rows=36710 width=37) (actual time=149.911..154.169 rows=881 loops=1)                                                                          |
  Group Key: m.id, m.name                                                                                                                                                               |
  Batches: 1  Memory Usage: 1681kB                                                                                                                                                      |
  ->  Gather  (cost=220151.56..224006.11 rows=36710 width=37) (actual time=148.792..153.374 rows=892 loops=1)                                                                           |
        Workers Planned: 2                                                                                                                                                              |
        Workers Launched: 2                                                                                                                                                             |
        ->  HashAggregate  (cost=219151.56..219335.11 rows=18355 width=37) (actual time=135.492..135.684 rows=297 loops=3)                                                              |
              Group Key: m.id, m.name                                                                                                                                                   |
              Batches: 1  Memory Usage: 849kB                                                                                                                                           |
              Worker 0:  Batches: 1  Memory Usage: 793kB                                                                                                                                |
              Worker 1:  Batches: 1  Memory Usage: 793kB                                                                                                                                |
              ->  Nested Loop Left Join  (cost=936.41..219059.78 rows=18355 width=37) (actual time=22.415..132.542 rows=14099 loops=3)                                                  |
                    ->  Parallel Bitmap Heap Scan on session s  (cost=935.98..96309.15 rows=18355 width=16) (actual time=16.143..57.071 rows=14099 loops=3)                             |
                          Recheck Cond: ((start_time >= (CURRENT_DATE + '00:00:00'::time without time zone)) AND (start_time < (CURRENT_DATE + '24:00:00'::time without time zone)))    |
                          Heap Blocks: exact=13149                                                                                                                                      |
                          ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..924.96 rows=44052 width=0) (actual time=18.474..18.474 rows=42297 loops=1)                       |
                                Index Cond: ((start_time >= (CURRENT_DATE + '00:00:00'::time without time zone)) AND (start_time < (CURRENT_DATE + '24:00:00'::time without time zone)))|
                    ->  Index Scan using movie_pk on movie m  (cost=0.43..6.69 rows=1 width=37) (actual time=0.004..0.004 rows=0 loops=42297)                                           |
                          Index Cond: (id = s.movie_id)                                                                                                                                 |
Planning Time: 0.257 ms                                                                                                                                                                 |
JIT:                                                                                                                                                                                    |
  Functions: 47                                                                                                                                                                         |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                         |
  Timing: Generation 3.419 ms, Inlining 0.000 ms, Optimization 1.500 ms, Emission 28.328 ms, Total 33.246 ms                                                                            |
Execution Time: 156.253 ms                                                                                                                                                              |                                                                                                                      |                                                                                                                           |                                                                                                         |
```

Используется индекс и выборка быстрее в 4 раза.