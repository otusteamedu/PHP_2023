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
| ticket  |66023|
| session | 1182|
| movie   |10000|
|  hall   |   30|

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
| session |13120|
| ticket  |66023|
| movie   |10000|
|  hall   |10030|

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

Результат:
```
```