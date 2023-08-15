# select-hall-scheme.sql

## Запрос:

```sql
EXPLAIN ANALYZE
    select s."row", s."number", t.price,
       case
           when t.status in (0) then 'Свободно'
           when t.status in (1,10) then 'Занято'
           when t.status in (2) then 'Бронь'
           end
    from seat s
    left join ticket t on s.id=t.seat_id
    where hall_id = '1906cfce-73fc-4e4b-9f35-bc10703030f4'  and t.session_id = 'a28b0a5b-3a0f-4b26-9286-cbd9465b4660'
    order by "row" asc , number::int asc
```

Количество записей в таблицах

```sql
select 'seat' as table, count(id) from "seat"
union
select 'ticket' as ticket, count(id) from "ticket"
```

| table  | count |
|--------|-------|
| seat   | 1909  |
| ticket | 66023 |

```
QUERY PLAN                                                                                                          |
--------------------------------------------------------------------------------------------------------------------+
Sort  (cost=1550.61..1550.61 rows=1 width=45) (actual time=8.419..8.422 rows=24 loops=1)                            |
  Sort Key: s."row", ((s.number)::integer)                                                                          |
  Sort Method: quicksort  Memory: 26kB                                                                              |
  ->  Hash Join  (cost=44.16..1550.60 rows=1 width=45) (actual time=2.026..8.384 rows=24 loops=1)                   |
        Hash Cond: (t.seat_id = s.id)                                                                               |
        ->  Seq Scan on ticket t  (cost=0.00..1506.29 rows=52 width=23) (actual time=1.752..8.095 rows=24 loops=1)  |
              Filter: (session_id = 'a28b0a5b-3a0f-4b26-9286-cbd9465b4660'::uuid)                                   |
              Rows Removed by Filter: 65999                                                                         |
        ->  Hash  (cost=43.86..43.86 rows=24 width=20) (actual time=0.257..0.258 rows=24 loops=1)                   |
              Buckets: 1024  Batches: 1  Memory Usage: 10kB                                                         |
              ->  Seq Scan on seat s  (cost=0.00..43.86 rows=24 width=20) (actual time=0.156..0.244 rows=24 loops=1)|
                    Filter: (hall_id = '1906cfce-73fc-4e4b-9f35-bc10703030f4'::uuid)                                |
                    Rows Removed by Filter: 1885                                                                    |
Planning Time: 0.514 ms                                                                                             |
Execution Time: 8.475 ms                                                                                            |                                                                                                                              |                                                                                                         |
```

### 10000

Добавим записей в таблицу `seat` выполнением `docker/postrgesql-initdb.d/72-insert-seat.sql`. Имеем:

| table  | count |
|--------|-------|
| seat   | 13363 |
| ticket | 66023 |

Результат:
```
QUERY PLAN                                                                                                             |
-----------------------------------------------------------------------------------------------------------------------+
Sort  (cost=1813.58..1813.59 rows=1 width=45) (actual time=10.070..10.074 rows=24 loops=1)                             |
  Sort Key: s."row", ((s.number)::integer)                                                                             |
  Sort Method: quicksort  Memory: 26kB                                                                                 |
  ->  Hash Join  (cost=307.14..1813.57 rows=1 width=45) (actual time=3.687..10.051 rows=24 loops=1)                    |
        Hash Cond: (t.seat_id = s.id)                                                                                  |
        ->  Seq Scan on ticket t  (cost=0.00..1506.29 rows=52 width=23) (actual time=1.746..8.095 rows=24 loops=1)     |
              Filter: (session_id = 'a28b0a5b-3a0f-4b26-9286-cbd9465b4660'::uuid)                                      |
              Rows Removed by Filter: 65999                                                                            |
        ->  Hash  (cost=305.04..305.04 rows=168 width=20) (actual time=1.913..1.914 rows=168 loops=1)                  |
              Buckets: 1024  Batches: 1  Memory Usage: 17kB                                                            |
              ->  Seq Scan on seat s  (cost=0.00..305.04 rows=168 width=20) (actual time=0.150..1.857 rows=168 loops=1)|
                    Filter: (hall_id = '1906cfce-73fc-4e4b-9f35-bc10703030f4'::uuid)                                   |
                    Rows Removed by Filter: 13195                                                                      |
Planning Time: 0.423 ms                                                                                                |
Execution Time: 10.138 ms                                                                                              |
```

### 10000000

Добавим записей в таблицу `seat` выполнением:

```sql
INSERT INTO public."seat" (hall_id, "number", "row")
select
    uuid_generate_v4() as hall_id,
    floor(random() * 2000 + 1)::int as "number",
    floor(random() * 2000 + 1)::int as "row"
FROM generate_series(1, 10000000);
```

| table  | count |
|--------|-------|
|  seat  |10013373|
| ticket |10066033|

Результат:
```
QUERY PLAN                                                                                                                              |
----------------------------------------------------------------------------------------------------------------------------------------+
Sort  (cost=157210.09..157210.09 rows=1 width=49) (actual time=345.181..347.722 rows=24 loops=1)                                        |
  Sort Key: s."row", ((s.number)::integer)                                                                                              |
  Sort Method: quicksort  Memory: 26kB                                                                                                  |
  ->  Gather  (cost=1000.45..157210.08 rows=1 width=49) (actual time=11.744..347.680 rows=24 loops=1)                                   |
        Workers Planned: 2                                                                                                              |
        Workers Launched: 2                                                                                                             |
        ->  Nested Loop  (cost=0.45..156209.98 rows=1 width=49) (actual time=221.280..332.360 rows=8 loops=3)                           |
              ->  Parallel Seq Scan on ticket t  (cost=0.00..156201.49 rows=1 width=23) (actual time=221.260..332.282 rows=8 loops=3)   |
                    Filter: (session_id = 'a28b0a5b-3a0f-4b26-9286-cbd9465b4660'::uuid)                                                 |
                    Rows Removed by Filter: 3355336                                                                                     |
              ->  Memoize  (cost=0.45..8.46 rows=1 width=24) (actual time=0.008..0.009 rows=1 loops=24)                                 |
                    Cache Key: t.seat_id                                                                                                |
                    Cache Mode: logical                                                                                                 |
                    Hits: 0  Misses: 24  Evictions: 0  Overflows: 0  Memory Usage: 4kB                                                  |
                    ->  Index Scan using seat_pk on seat s  (cost=0.43..8.46 rows=1 width=24) (actual time=0.007..0.007 rows=1 loops=24)|
                          Index Cond: (id = t.seat_id)                                                                                  |
                          Filter: (hall_id = '1906cfce-73fc-4e4b-9f35-bc10703030f4'::uuid)                                              |
Planning Time: 0.424 ms                                                                                                                 |
JIT:                                                                                                                                    |
  Functions: 45                                                                                                                         |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                         |
  Timing: Generation 3.183 ms, Inlining 0.000 ms, Optimization 1.358 ms, Emission 32.309 ms, Total 36.849 ms                            |
Execution Time: 348.531 ms                                                                                                              |
```