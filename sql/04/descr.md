# select-most-profit-movie.sql

## Запрос:

```sql
EXPLAIN ANALYZE
    select s.movie_id, m."name", count(t.id) as cnt, sum(t.price) as price from ticket t
    left join "session" s on t.session_id=s.id
    left join movie m on s.movie_id =m.id
    where
        t.status = 1 AND
        s.start_time::date between (CURRENT_DATE - interval '1 WEEK') and CURRENT_DATE
    group by s.movie_id, m."name"
    order by price desc
    limit 3
```

Количество записей в таблицах

```sql
select 'ticket' as table, count(id) from "ticket"
union
select 'session' as table, count(id) from "session"
union
select 'movie' as table, count(id) from "movie"
```

| table   | count |
|---------|-------|
| movie   |10000|
| session | 1182|
| ticket  |66023|

```
QUERY PLAN                                                                                                                                                |
----------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=1713.61..1713.62 rows=3 width=77) (actual time=54.068..54.072 rows=3 loops=1)                                                                |
  ->  Sort  (cost=1713.61..1714.03 rows=166 width=77) (actual time=54.067..54.070 rows=3 loops=1)                                                         |
        Sort Key: (sum(t.price)) DESC                                                                                                                     |
        Sort Method: top-N heapsort  Memory: 25kB                                                                                                         |
        ->  GroupAggregate  (cost=1707.32..1711.47 rows=166 width=77) (actual time=44.119..53.795 rows=759 loops=1)                                       |
              Group Key: s.movie_id, m.name                                                                                                               |
              ->  Sort  (cost=1707.32..1707.73 rows=166 width=58) (actual time=44.089..45.546 rows=21925 loops=1)                                         |
                    Sort Key: s.movie_id, m.name                                                                                                          |
                    Sort Method: quicksort  Memory: 2995kB                                                                                                |
                    ->  Nested Loop Left Join  (cost=46.88..1701.20 rows=166 width=58) (actual time=1.887..34.775 rows=21925 loops=1)                     |
                          ->  Hash Join  (cost=46.58..1639.23 rows=166 width=37) (actual time=1.864..19.697 rows=21925 loops=1)                           |
                                Hash Cond: (t.session_id = s.id)                                                                                          |
                                ->  Seq Scan on ticket t  (cost=0.00..1506.29 rows=32783 width=37) (actual time=0.007..10.557 rows=32836 loops=1)         |
                                      Filter: (status = 1)                                                                                                |
                                      Rows Removed by Filter: 33187                                                                                       |
                                ->  Hash  (cost=46.51..46.51 rows=6 width=32) (actual time=0.674..0.675 rows=789 loops=1)                                 |
                                      Buckets: 1024  Batches: 1  Memory Usage: 58kB                                                                       |
                                      ->  Seq Scan on session s  (cost=0.00..46.51 rows=6 width=32) (actual time=0.039..0.484 rows=789 loops=1)           |
                                            Filter: (((start_time)::date <= CURRENT_DATE) AND ((start_time)::date >= (CURRENT_DATE - '7 days'::interval)))|
                                            Rows Removed by Filter: 393                                                                                   |
                          ->  Memoize  (cost=0.30..8.31 rows=1 width=37) (actual time=0.000..0.000 rows=1 loops=21925)                                    |
                                Cache Key: s.movie_id                                                                                                     |
                                Cache Mode: logical                                                                                                       |
                                Hits: 21166  Misses: 759  Evictions: 0  Overflows: 0  Memory Usage: 111kB                                                 |
                                ->  Index Scan using movie_pk on movie m  (cost=0.29..8.30 rows=1 width=37) (actual time=0.003..0.003 rows=1 loops=759)   |
                                      Index Cond: (id = s.movie_id)                                                                                       |
Planning Time: 0.469 ms                                                                                                                                   |
Execution Time: 54.369 ms                                                                                                                                 |                                                                                                         |
```

### 10000

После выполнения шага [03-10000](../03/descr.md#10000). Имеем:

|table  | count |
|-------|-------|
|movie  | 10000 |
|session| 13120 |
|ticket | 66023 |

Результат:
```
QUERY PLAN                                                                                                                                                |
----------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=2484.76..2484.77 rows=3 width=77) (actual time=56.092..56.097 rows=3 loops=1)                                                                |
  ->  Sort  (cost=2484.76..2485.17 rows=165 width=77) (actual time=56.091..56.095 rows=3 loops=1)                                                         |
        Sort Key: (sum(t.price)) DESC                                                                                                                     |
        Sort Method: top-N heapsort  Memory: 25kB                                                                                                         |
        ->  GroupAggregate  (cost=2478.50..2482.63 rows=165 width=77) (actual time=46.184..55.866 rows=759 loops=1)                                       |
              Group Key: s.movie_id, m.name                                                                                                               |
              ->  Sort  (cost=2478.50..2478.91 rows=165 width=58) (actual time=46.150..47.548 rows=21925 loops=1)                                         |
                    Sort Key: s.movie_id, m.name                                                                                                          |
                    Sort Method: quicksort  Memory: 2995kB                                                                                                |
                    ->  Hash Left Join  (cost=879.62..2472.42 rows=165 width=58) (actual time=12.211..36.764 rows=21925 loops=1)                          |
                          Hash Cond: (s.movie_id = m.id)                                                                                                  |
                          ->  Hash Join  (cost=511.63..2103.99 rows=165 width=37) (actual time=7.984..25.413 rows=21925 loops=1)                          |
                                Hash Cond: (t.session_id = s.id)                                                                                          |
                                ->  Seq Scan on ticket t  (cost=0.00..1506.29 rows=32783 width=37) (actual time=0.009..10.117 rows=32836 loops=1)         |
                                      Filter: (status = 1)                                                                                                |
                                      Rows Removed by Filter: 33187                                                                                       |
                                ->  Hash  (cost=510.80..510.80 rows=66 width=32) (actual time=6.847..6.848 rows=7292 loops=1)                             |
                                      Buckets: 8192 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 520kB                                     |
                                      ->  Seq Scan on session s  (cost=0.00..510.80 rows=66 width=32) (actual time=0.039..5.090 rows=7292 loops=1)        |
                                            Filter: (((start_time)::date <= CURRENT_DATE) AND ((start_time)::date >= (CURRENT_DATE - '7 days'::interval)))|
                                            Rows Removed by Filter: 5828                                                                                  |
                          ->  Hash  (cost=243.00..243.00 rows=10000 width=37) (actual time=4.169..4.169 rows=10000 loops=1)                               |
                                Buckets: 16384  Batches: 1  Memory Usage: 802kB                                                                           |
                                ->  Seq Scan on movie m  (cost=0.00..243.00 rows=10000 width=37) (actual time=0.004..1.642 rows=10000 loops=1)            |
Planning Time: 0.465 ms                                                                                                                                   |
Execution Time: 56.505 ms                                                                                                                                 |
```

### 10000000

Результат:
```
```