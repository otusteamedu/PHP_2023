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

| table    | count |
|----------|-------|
|  session | 1182|
| ticket   |66023|

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

| table    | count |
|----------|-------|
|  session |13120|
| ticket   |66023|

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

Результат:
```
```