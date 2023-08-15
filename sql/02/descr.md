# select-ticket-week.sql

## Запрос:

```sql
EXPLAIN ANALYZE
    select count(t.id) as cnt, sum(t.price) as price from ticket t
    left join "session" s on t.session_id=s.id
    where
        t.status = 1 AND
        s.start_time::date between (CURRENT_DATE - interval '1 WEEK') and CURRENT_DATE
```

Количество записей в таблицах

```sql
select 'session' as table, count(id) from "session"
union
select 'ticket' as table, count(id) from "ticket"
```

| table   | count |
|---------|-------|
| session | 1182  |
| ticket  | 66023 |

```
QUERY PLAN                                                                                                                        |
----------------------------------------------------------------------------------------------------------------------------------+
Aggregate  (cost=1640.07..1640.08 rows=1 width=40) (actual time=25.637..25.639 rows=1 loops=1)                                    |
  ->  Hash Join  (cost=46.58..1639.23 rows=166 width=21) (actual time=2.057..21.801 rows=21925 loops=1)                           |
        Hash Cond: (t.session_id = s.id)                                                                                          |
        ->  Seq Scan on ticket t  (cost=0.00..1506.29 rows=32783 width=37) (actual time=0.014..13.264 rows=32836 loops=1)         |
              Filter: (status = 1)                                                                                                |
              Rows Removed by Filter: 33187                                                                                       |
        ->  Hash  (cost=46.51..46.51 rows=6 width=16) (actual time=0.614..0.614 rows=789 loops=1)                                 |
              Buckets: 1024  Batches: 1  Memory Usage: 45kB                                                                       |
              ->  Seq Scan on session s  (cost=0.00..46.51 rows=6 width=16) (actual time=0.039..0.459 rows=789 loops=1)           |
                    Filter: (((start_time)::date <= CURRENT_DATE) AND ((start_time)::date >= (CURRENT_DATE - '7 days'::interval)))|
                    Rows Removed by Filter: 393                                                                                   |
Planning Time: 0.479 ms                                                                                                           |
Execution Time: 25.689 ms                                                                                                         |
```

### 10000

После выполнения шага [01-10000](../01/descr.md#10000). Имеем:

| table   | count |
|---------|-------|
| session | 13120 |
| ticket  | 66023 |

Результат:
```
QUERY PLAN                                                                                                                        |
----------------------------------------------------------------------------------------------------------------------------------+
Aggregate  (cost=2104.82..2104.83 rows=1 width=40) (actual time=27.826..27.828 rows=1 loops=1)                                    |
  ->  Hash Join  (cost=511.63..2103.99 rows=165 width=21) (actual time=7.410..23.957 rows=21925 loops=1)                          |
        Hash Cond: (t.session_id = s.id)                                                                                          |
        ->  Seq Scan on ticket t  (cost=0.00..1506.29 rows=32783 width=37) (actual time=0.006..9.890 rows=32836 loops=1)          |
              Filter: (status = 1)                                                                                                |
              Rows Removed by Filter: 33187                                                                                       |
        ->  Hash  (cost=510.80..510.80 rows=66 width=16) (actual time=6.291..6.291 rows=7292 loops=1)                             |
              Buckets: 8192 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 406kB                                     |
              ->  Seq Scan on session s  (cost=0.00..510.80 rows=66 width=16) (actual time=0.041..4.783 rows=7292 loops=1)        |
                    Filter: (((start_time)::date <= CURRENT_DATE) AND ((start_time)::date >= (CURRENT_DATE - '7 days'::interval)))|
                    Rows Removed by Filter: 5828                                                                                  |
Planning Time: 0.317 ms                                                                                                           |
Execution Time: 27.949 ms                                                                                                         |
```

### 10000000

Добавим записей в таблицу `ticket` выполнением:

```sql
INSERT INTO public."ticket" (session_id, seat_id, price, status)
select
    uuid_generate_v4() as session_id,
    uuid_generate_v4() as seat_id,
    floor(random() * 2000 + 30)::int as price,
    round(random()) as status
FROM generate_series(1, 10000000);
```

| table    | count |
|----------|-------|
|  session |10013306|
| ticket   |10066033|

Результат:
```
QUERY PLAN                                                                                                                                               |
---------------------------------------------------------------------------------------------------------------------------------------------------------+
Finalize Aggregate  (cost=210167.30..210167.31 rows=1 width=40) (actual time=22204.420..22218.458 rows=1 loops=1)                                        |
  ->  Gather  (cost=210167.07..210167.28 rows=2 width=40) (actual time=22203.469..22218.427 rows=3 loops=1)                                              |
        Workers Planned: 2                                                                                                                               |
        Workers Launched: 2                                                                                                                              |
        ->  Partial Aggregate  (cost=209167.07..209167.08 rows=1 width=40) (actual time=22189.671..22189.672 rows=1 loops=3)                             |
              ->  Nested Loop  (cost=0.57..209115.03 rows=10408 width=21) (actual time=42.163..22188.812 rows=7308 loops=3)                              |
                    ->  Parallel Seq Scan on ticket t  (cost=0.00..156174.51 rows=2081488 width=37) (actual time=10.929..615.101 rows=1678570 loops=3)   |
                          Filter: (status = 1)                                                                                                           |
                          Rows Removed by Filter: 1676774                                                                                                |
                    ->  Memoize  (cost=0.57..0.77 rows=1 width=16) (actual time=0.013..0.013 rows=0 loops=5035711)                                       |
                          Cache Key: t.session_id                                                                                                        |
                          Cache Mode: logical                                                                                                            |
                          Hits: 11926  Misses: 1667559  Evictions: 1562702  Overflows: 0  Memory Usage: 8193kB                                           |
                          Worker 0:  Hits: 8924  Misses: 1665927  Evictions: 1561070  Overflows: 0  Memory Usage: 8193kB                                 |
                          Worker 1:  Hits: 10794  Misses: 1670581  Evictions: 1565724  Overflows: 0  Memory Usage: 8193kB                                |
                          ->  Index Scan using session_pk on session s  (cost=0.56..0.76 rows=1 width=16) (actual time=0.012..0.012 rows=0 loops=5004067)|
                                Index Cond: (id = t.session_id)                                                                                          |
                                Filter: (((start_time)::date <= CURRENT_DATE) AND ((start_time)::date >= (CURRENT_DATE - '7 days'::interval)))           |
                                Rows Removed by Filter: 0                                                                                                |
Planning Time: 380.456 ms                                                                                                                                |
JIT:                                                                                                                                                     |
  Functions: 50                                                                                                                                          |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                          |
  Timing: Generation 3.147 ms, Inlining 0.000 ms, Optimization 1.348 ms, Emission 31.536 ms, Total 36.031 ms                                             |
Execution Time: 22233.049 ms                                                                                                                             |
```

### Оптимизация

Индекс `session_start_time_idx` был добавлен ранее.  
Добавим индекс
```sql
CREATE INDEX ticket_status_idx ON public.ticket (status);
```

Результат:
```
QUERY PLAN                                                                                                                                                 |
-----------------------------------------------------------------------------------------------------------------------------------------------------------+
Finalize Aggregate  (cost=426101.89..426101.90 rows=1 width=40) (actual time=1877.818..1880.480 rows=1 loops=1)                                            |
  ->  Gather  (cost=426101.67..426101.88 rows=2 width=40) (actual time=1876.890..1880.457 rows=3 loops=1)                                                  |
        Workers Planned: 2                                                                                                                                 |
        Workers Launched: 2                                                                                                                                |
        ->  Partial Aggregate  (cost=425101.67..425101.68 rows=1 width=40) (actual time=1864.751..1864.754 rows=1 loops=3)                                 |
              ->  Parallel Hash Join  (cost=263337.56..425049.18 rows=10496 width=21) (actual time=1053.348..1863.798 rows=7308 loops=3)                   |
                    Hash Cond: (t.session_id = s.id)                                                                                                       |
                    ->  Parallel Seq Scan on ticket t  (cost=0.00..156201.26 rows=2099188 width=37) (actual time=0.034..469.895 rows=1678570 loops=3)      |
                          Filter: (status = 1)                                                                                                             |
                          Rows Removed by Filter: 1676774                                                                                                  |
                    ->  Parallel Hash  (cost=263076.80..263076.80 rows=20861 width=16) (actual time=1052.650..1052.651 rows=113143 loops=3)                |
                          Buckets: 524288 (originally 65536)  Batches: 1 (originally 1)  Memory Usage: 23680kB                                             |
                          ->  Parallel Seq Scan on session s  (cost=0.00..263076.80 rows=20861 width=16) (actual time=10.642..1010.813 rows=113143 loops=3)|
                                Filter: (((start_time)::date <= CURRENT_DATE) AND ((start_time)::date >= (CURRENT_DATE - '7 days'::interval)))             |
                                Rows Removed by Filter: 3224625                                                                                            |
Planning Time: 0.268 ms                                                                                                                                    |
JIT:                                                                                                                                                       |
  Functions: 50                                                                                                                                            |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                            |
  Timing: Generation 2.973 ms, Inlining 0.000 ms, Optimization 1.357 ms, Emission 30.598 ms, Total 34.928 ms                                               |
Execution Time: 1881.476 ms                                                                                                                                |                                                                                                         |
```

Изменим запрос на
```sql
EXPLAIN ANALYZE
    select count(t.id) as cnt, sum(t.price) as price from ticket t
    left join "session" s on t.session_id=s.id
    where
        t.status = 1 AND
        s.start_time between (CURRENT_DATE - interval '1 WEEK') + '00:00:00'::time and CURRENT_DATE + '24:00:00'::time
```
Результат:
```
QUERY PLAN                                                                                                                                                                                              |
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Finalize Aggregate  (cost=410965.53..410965.54 rows=1 width=40) (actual time=1559.298..1563.736 rows=1 loops=1)                                                                                         |
  ->  Gather  (cost=410965.30..410965.51 rows=2 width=40) (actual time=1558.247..1563.709 rows=3 loops=1)                                                                                               |
        Workers Planned: 2                                                                                                                                                                              |
        Workers Launched: 2                                                                                                                                                                             |
        ->  Partial Aggregate  (cost=409965.30..409965.31 rows=1 width=40) (actual time=1544.944..1544.949 rows=1 loops=3)                                                                              |
              ->  Parallel Hash Join  (cost=247886.25..409597.88 rows=73484 width=21) (actual time=702.561..1543.979 rows=7308 loops=3)                                                                 |
                    Hash Cond: (t.session_id = s.id)                                                                                                                                                    |
                    ->  Parallel Seq Scan on ticket t  (cost=0.00..156201.26 rows=2099188 width=37) (actual time=0.057..472.366 rows=1678570 loops=3)                                                   |
                          Filter: (status = 1)                                                                                                                                                          |
                          Rows Removed by Filter: 1676774                                                                                                                                               |
                    ->  Parallel Hash  (cost=246060.60..246060.60 rows=146052 width=16) (actual time=701.401..701.404 rows=113143 loops=3)                                                              |
                          Buckets: 524288  Batches: 1  Memory Usage: 20064kB                                                                                                                            |
                          ->  Parallel Bitmap Heap Scan on session s  (cost=7441.32..246060.60 rows=146052 width=16) (actual time=59.729..660.379 rows=113143 loops=3)                                  |
                                Recheck Cond: ((start_time >= ((CURRENT_DATE - '7 days'::interval) + '00:00:00'::interval)) AND (start_time <= (CURRENT_DATE + '24:00:00'::time without time zone)))    |
                                Rows Removed by Index Recheck: 1861683                                                                                                                                  |
                                Heap Blocks: exact=15526 lossy=24006                                                                                                                                    |
                                ->  Bitmap Index Scan on session_start_time_idx  (cost=0.00..7353.69 rows=350524 width=0) (actual time=51.440..51.440 rows=339430 loops=1)                              |
                                      Index Cond: ((start_time >= ((CURRENT_DATE - '7 days'::interval) + '00:00:00'::interval)) AND (start_time <= (CURRENT_DATE + '24:00:00'::time without time zone)))|
Planning Time: 0.462 ms                                                                                                                                                                                 |
JIT:                                                                                                                                                                                                    |
  Functions: 56                                                                                                                                                                                         |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                                         |
  Timing: Generation 3.698 ms, Inlining 0.000 ms, Optimization 1.756 ms, Emission 33.783 ms, Total 39.237 ms                                                                                            |
Execution Time: 1564.972 ms                                                                                                                                                                             |
```

Индекс используется, но ускорение незначительное.
