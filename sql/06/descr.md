# select-session-price-minmax.sql

## Запрос:

```sql
EXPLAIN ANALYZE
    select m."name", s.start_time, h."name", min(t.price) as price_min, max(t.price) as price_max from ticket t
    left join "session" s ON t.session_id=s.id
    left join movie m on s.movie_id = m.id
    left join hall h  on s.hall_id = h.id
    where t.session_id ='e0f96958-19fb-489e-bcb4-7f6e4d10db28'
    group by m."name", s.start_time, h."name"
```

Количество записей в таблицах

```sql
select 'ticket' as table, count(id) from "ticket"
union
select 'session' as ticket, count(id) from "session"
union
select 'movie' as ticket, count(id) from "movie"
union
select 'hall' as ticket, count(id) from "hall"
```

| table   | count |
|---------|-------|
| ticket  | 66023 |
| session | 1182  |
| movie   | 10000 |
| hall    | 30    |

```
QUERY PLAN                                                                                                                                               |
---------------------------------------------------------------------------------------------------------------------------------------------------------+
GroupAggregate  (cost=1533.34..1534.64 rows=52 width=125) (actual time=8.128..8.130 rows=1 loops=1)                                                      |
  Group Key: m.name, s.start_time, h.name                                                                                                                |
  ->  Sort  (cost=1533.34..1533.47 rows=52 width=66) (actual time=8.062..8.076 rows=52 loops=1)                                                          |
        Sort Key: m.name, s.start_time, h.name                                                                                                           |
        Sort Method: quicksort  Memory: 29kB                                                                                                             |
        ->  Nested Loop Left Join  (cost=0.71..1531.85 rows=52 width=66) (actual time=1.785..8.025 rows=52 loops=1)                                      |
              Join Filter: (t.session_id = s.id)                                                                                                         |
              ->  Seq Scan on ticket t  (cost=0.00..1506.29 rows=52 width=21) (actual time=1.732..7.941 rows=52 loops=1)                                 |
                    Filter: (session_id = 'e0f96958-19fb-489e-bcb4-7f6e4d10db28'::uuid)                                                                  |
                    Rows Removed by Filter: 65971                                                                                                        |
              ->  Materialize  (cost=0.71..24.79 rows=1 width=77) (actual time=0.001..0.001 rows=1 loops=52)                                             |
                    ->  Nested Loop Left Join  (cost=0.71..24.78 rows=1 width=77) (actual time=0.042..0.044 rows=1 loops=1)                              |
                          ->  Nested Loop Left Join  (cost=0.56..16.60 rows=1 width=61) (actual time=0.031..0.033 rows=1 loops=1)                        |
                                ->  Index Scan using session_pk on session s  (cost=0.28..8.29 rows=1 width=56) (actual time=0.016..0.017 rows=1 loops=1)|
                                      Index Cond: (id = 'e0f96958-19fb-489e-bcb4-7f6e4d10db28'::uuid)                                                    |
                                ->  Index Scan using movie_pk on movie m  (cost=0.29..8.30 rows=1 width=37) (actual time=0.011..0.011 rows=1 loops=1)    |
                                      Index Cond: (id = s.movie_id)                                                                                      |
                          ->  Index Scan using hall_pkey on hall h  (cost=0.15..8.17 rows=1 width=48) (actual time=0.009..0.009 rows=1 loops=1)          |
                                Index Cond: (id = s.hall_id)                                                                                             |
Planning Time: 0.518 ms                                                                                                                                  |
Execution Time: 8.267 ms                                                                                                                                 |                                                                                          |                                                                                                                              |                                                                                                         |
```

### 10000

Добавим записей в таблицу `hall` выполнением `docker/postrgesql-initdb.d/70-insert-hall.sql`. Имеем:

| table   | count |
|---------|-------|
| session | 13120 |
| ticket  | 66023 |
| movie   | 10000 |
| hall    | 10030 |

Результат:
```
QUERY PLAN                                                                                                                                               |
---------------------------------------------------------------------------------------------------------------------------------------------------------+
GroupAggregate  (cost=1533.46..1534.76 rows=52 width=110) (actual time=8.298..8.301 rows=1 loops=1)                                                      |
  Group Key: m.name, s.start_time, h.name                                                                                                                |
  ->  Sort  (cost=1533.46..1533.59 rows=52 width=51) (actual time=8.240..8.246 rows=52 loops=1)                                                          |
        Sort Key: m.name, s.start_time, h.name                                                                                                           |
        Sort Method: quicksort  Memory: 29kB                                                                                                             |
        ->  Nested Loop Left Join  (cost=0.86..1531.98 rows=52 width=51) (actual time=1.820..8.213 rows=52 loops=1)                                      |
              Join Filter: (t.session_id = s.id)                                                                                                         |
              ->  Seq Scan on ticket t  (cost=0.00..1506.29 rows=52 width=21) (actual time=1.758..8.119 rows=52 loops=1)                                 |
                    Filter: (session_id = 'e0f96958-19fb-489e-bcb4-7f6e4d10db28'::uuid)                                                                  |
                    Rows Removed by Filter: 65971                                                                                                        |
              ->  Materialize  (cost=0.86..24.92 rows=1 width=62) (actual time=0.001..0.001 rows=1 loops=52)                                             |
                    ->  Nested Loop Left Join  (cost=0.86..24.91 rows=1 width=62) (actual time=0.054..0.056 rows=1 loops=1)                              |
                          ->  Nested Loop Left Join  (cost=0.57..16.61 rows=1 width=61) (actual time=0.033..0.034 rows=1 loops=1)                        |
                                ->  Index Scan using session_pk on session s  (cost=0.29..8.30 rows=1 width=56) (actual time=0.017..0.018 rows=1 loops=1)|
                                      Index Cond: (id = 'e0f96958-19fb-489e-bcb4-7f6e4d10db28'::uuid)                                                    |
                                ->  Index Scan using movie_pk on movie m  (cost=0.29..8.30 rows=1 width=37) (actual time=0.012..0.012 rows=1 loops=1)    |
                                      Index Cond: (id = s.movie_id)                                                                                      |
                          ->  Index Scan using hall_pkey on hall h  (cost=0.29..8.30 rows=1 width=33) (actual time=0.020..0.020 rows=1 loops=1)          |
                                Index Cond: (id = s.hall_id)                                                                                             |
Planning Time: 0.470 ms                                                                                                                                  |
Execution Time: 8.371 ms                                                                                                                                 |
```

### 10000000

Добавим записей в таблицу `hall` выполнением `docker/postrgesql-initdb.d/70-insert-hall.sql`. Имеем:

| table   | count |
|---------|-------|
|  hall   |10010030|
| ticket  |10066033|
| movie   |10010000|
| session |10013306|

Результат:
```
QUERY PLAN                                                                                                                                                |
----------------------------------------------------------------------------------------------------------------------------------------------------------+
GroupAggregate  (cost=157227.19..157227.24 rows=2 width=110) (actual time=330.668..332.844 rows=1 loops=1)                                                |
  Group Key: m.name, s.start_time, h.name                                                                                                                 |
  ->  Sort  (cost=157227.19..157227.20 rows=2 width=51) (actual time=330.613..332.792 rows=52 loops=1)                                                    |
        Sort Key: m.name, s.start_time, h.name                                                                                                            |
        Sort Method: quicksort  Memory: 29kB                                                                                                              |
        ->  Gather  (cost=1001.43..157227.18 rows=2 width=51) (actual time=19.366..332.738 rows=52 loops=1)                                               |
              Workers Planned: 2                                                                                                                          |
              Workers Launched: 2                                                                                                                         |
              ->  Nested Loop Left Join  (cost=1.43..156226.98 rows=1 width=51) (actual time=213.449..317.128 rows=17 loops=3)                            |
                    ->  Nested Loop Left Join  (cost=1.00..156218.53 rows=1 width=50) (actual time=213.439..317.085 rows=17 loops=3)                      |
                          ->  Nested Loop Left Join  (cost=0.56..156210.08 rows=1 width=45) (actual time=213.428..317.040 rows=17 loops=3)                |
                                Join Filter: (t.session_id = s.id)                                                                                        |
                                ->  Parallel Seq Scan on ticket t  (cost=0.00..156201.49 rows=1 width=21) (actual time=213.408..316.983 rows=17 loops=3)  |
                                      Filter: (session_id = 'e0f96958-19fb-489e-bcb4-7f6e4d10db28'::uuid)                                                 |
                                      Rows Removed by Filter: 3355327                                                                                     |
                                ->  Index Scan using session_pk on session s  (cost=0.56..8.58 rows=1 width=56) (actual time=0.003..0.003 rows=1 loops=52)|
                                      Index Cond: (id = 'e0f96958-19fb-489e-bcb4-7f6e4d10db28'::uuid)                                                     |
                          ->  Index Scan using movie_pk on movie m  (cost=0.43..8.45 rows=1 width=37) (actual time=0.002..0.002 rows=1 loops=52)          |
                                Index Cond: (id = s.movie_id)                                                                                             |
                    ->  Index Scan using hall_pkey on hall h  (cost=0.43..8.45 rows=1 width=33) (actual time=0.002..0.002 rows=1 loops=52)                |
                          Index Cond: (id = s.hall_id)                                                                                                    |
Planning Time: 0.652 ms                                                                                                                                   |
JIT:                                                                                                                                                      |
  Functions: 65                                                                                                                                           |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                           |
  Timing: Generation 3.713 ms, Inlining 0.000 ms, Optimization 2.226 ms, Emission 39.767 ms, Total 45.706 ms                                              |
Execution Time: 334.284 ms                                                                                                                                |
```

### Оптимизация

Индекс `ticket_session_id_idx` был добавлен ранее.
Результат:
```
QUERY PLAN                                                                                                                                               |
---------------------------------------------------------------------------------------------------------------------------------------------------------+
GroupAggregate  (cost=37.99..38.04 rows=2 width=110) (actual time=0.230..0.232 rows=1 loops=1)                                                           |
  Group Key: m.name, s.start_time, h.name                                                                                                                |
  ->  Sort  (cost=37.99..38.00 rows=2 width=51) (actual time=0.194..0.198 rows=52 loops=1)                                                               |
        Sort Key: m.name, s.start_time, h.name                                                                                                           |
        Sort Method: quicksort  Memory: 29kB                                                                                                             |
        ->  Nested Loop Left Join  (cost=1.87..37.98 rows=2 width=51) (actual time=0.104..0.148 rows=52 loops=1)                                         |
              Join Filter: (t.session_id = s.id)                                                                                                         |
              ->  Index Scan using ticket_session_id_idx on ticket t  (cost=0.43..12.47 rows=2 width=21) (actual time=0.039..0.050 rows=52 loops=1)      |
                    Index Cond: (session_id = 'e0f96958-19fb-489e-bcb4-7f6e4d10db28'::uuid)                                                              |
              ->  Materialize  (cost=1.43..25.49 rows=1 width=62) (actual time=0.001..0.001 rows=1 loops=52)                                             |
                    ->  Nested Loop Left Join  (cost=1.43..25.48 rows=1 width=62) (actual time=0.057..0.059 rows=1 loops=1)                              |
                          ->  Nested Loop Left Join  (cost=1.00..17.03 rows=1 width=61) (actual time=0.038..0.039 rows=1 loops=1)                        |
                                ->  Index Scan using session_pk on session s  (cost=0.56..8.58 rows=1 width=56) (actual time=0.021..0.022 rows=1 loops=1)|
                                      Index Cond: (id = 'e0f96958-19fb-489e-bcb4-7f6e4d10db28'::uuid)                                                    |
                                ->  Index Scan using movie_pk on movie m  (cost=0.43..8.45 rows=1 width=37) (actual time=0.013..0.013 rows=1 loops=1)    |
                                      Index Cond: (id = s.movie_id)                                                                                      |
                          ->  Index Scan using hall_pkey on hall h  (cost=0.43..8.45 rows=1 width=33) (actual time=0.017..0.017 rows=1 loops=1)          |
                                Index Cond: (id = s.hall_id)                                                                                             |
Planning Time: 0.629 ms                                                                                                                                  |
Execution Time: 0.318 ms                                                                                                                                 |                                                                                                                   |                                                                                                                           |                                                                                                         |
```

Индексы - есть, ускорение - есть.
