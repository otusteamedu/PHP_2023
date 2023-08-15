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
|  seat  | 1909|
| ticket |66023|

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

| table   | count |
|---------|-------|
| seat    |13363|
|  ticket |66023|

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

Результат:
```
```