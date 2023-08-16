### Замечания
```
В 4 запросе ускорения не получилось. Самая тяжелая часть выборки - это даты.
Как можно изменить их хранение так, чтобы они более эффективно индексировались?

Можно ли денормализовать данные так, чтобы уменьшить кол-во join-ов?
```

Избавляемся от `join` и разделяем `timestamp` на `date` и `time`
```sql
drop table if exists public.ticket_2;
CREATE TABLE public.ticket_2 (
    id uuid NOT NULL DEFAULT uuid_generate_v4(),
    session_id uuid NOT NULL,
    seat_id uuid NOT NULL,
    price numeric(10, 2) NOT NULL DEFAULT 0.0,
    status int2 NULL DEFAULT 0, -- 0-доступен, 1-продан,2-забронирован,10-не доступен
    start_timestamp timestamp NOT NULL,
    movie_id uuid NOT NULL,
    start_date date NOT NULL,
    start_time time NOT NULL,
    CONSTRAINT ticket_2_pk PRIMARY KEY (id)
);
CREATE INDEX ticket_2_session_id_idx ON public.ticket_2 (session_id);
CREATE INDEX ticket_2_status_idx ON public.ticket_2 USING btree (status);
CREATE INDEX ticket_2_start_timestamp_idx ON public.ticket_2 USING btree (start_timestamp);
CREATE INDEX ticket_2_start_date_idx ON public.ticket_2 USING btree (start_date);
CREATE INDEX ticket_2_start_time_idx ON public.ticket_2 USING btree (start_time);
CREATE INDEX ticket_2_movie_id_idx ON public.ticket_2 USING btree (movie_id);

INSERT INTO ticket_2 (id,session_id,seat_id,price,status,start_timestamp,start_date,start_time, movie_id)
SELECT t.id, t.session_id, t.seat_id, t.price, t.status,
       CASE WHEN s.start_time IS NULL
            THEN timestamp '2023-01-01 08:00:00' + random() * (timestamp '2023-08-30 20:00:00' - timestamp '2023-01-01 08:00:00')
            ELSE s.start_time
           end as start_timestamp,
       CASE WHEN s.start_time IS NULL
            THEN (timestamp '2023-01-01 08:00:00' + random() * (timestamp '2023-08-30 20:00:00' - timestamp '2023-01-01 08:00:00'))::date
            ELSE s.start_time::date
           end as start_date,
       CASE WHEN s.start_time IS NULL
            THEN (timestamp '2023-01-01 08:00:00' + random() * (timestamp '2023-08-30 20:00:00' - timestamp '2023-01-01 08:00:00'))::time
            ELSE s.start_time::time
           end as start_time,
       CASE WHEN s.movie_id IS NULL
            THEN uuid_generate_v4()
            ELSE s.movie_id
        end as movie_id
FROM ticket t
left join "session" s on t.session_id =s.id
```

Запрос
```sql
EXPLAIN ANALYZE
select t.movie_id, count(t.id) as cnt, sum(t.price) as price from ticket_2 t
where
    t.status = 1 AND
    t.start_date between (CURRENT_DATE - interval '1 WEEK')::date and CURRENT_DATE::date
group by t.movie_id
order by price desc
limit 3
```

Результат
```
QUERY PLAN                                                                                                                                                                       |
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=290820.12..290820.13 rows=3 width=56) (actual time=1094.529..1096.843 rows=3 loops=1)                                                                               |
  ->  Sort  (cost=290820.12..291324.30 rows=201670 width=56) (actual time=1083.021..1085.334 rows=3 loops=1)                                                                     |
        Sort Key: (sum(price)) DESC                                                                                                                                              |
        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                                |
        ->  Finalize GroupAggregate  (cost=262476.30..288213.58 rows=201670 width=56) (actual time=793.973..1042.533 rows=166125 loops=1)                                        |
              Group Key: movie_id                                                                                                                                                |
              ->  Gather Merge  (cost=262476.30..283994.04 rows=169866 width=56) (actual time=793.958..898.092 rows=166740 loops=1)                                              |
                    Workers Planned: 2                                                                                                                                           |
                    Workers Launched: 2                                                                                                                                          |
                    ->  Partial GroupAggregate  (cost=261476.27..263387.27 rows=84933 width=56) (actual time=780.550..826.080 rows=55580 loops=3)                                |
                          Group Key: movie_id                                                                                                                                    |
                          ->  Sort  (cost=261476.27..261688.61 rows=84933 width=37) (actual time=780.494..789.114 rows=62390 loops=3)                                            |
                                Sort Key: movie_id                                                                                                                               |
                                Sort Method: external merge  Disk: 2920kB                                                                                                        |
                                Worker 0:  Sort Method: external merge  Disk: 2840kB                                                                                             |
                                Worker 1:  Sort Method: external merge  Disk: 2864kB                                                                                             |
                                ->  Parallel Bitmap Heap Scan on ticket_2 t  (cost=5415.97..252198.79 rows=84933 width=37) (actual time=36.708..747.567 rows=62390 loops=3)      |
                                      Recheck Cond: ((start_date >= ((CURRENT_DATE - '7 days'::interval))::date) AND (start_date <= CURRENT_DATE))                               |
                                      Rows Removed by Index Recheck: 2055112                                                                                                     |
                                      Filter: (status = 1)                                                                                                                       |
                                      Rows Removed by Filter: 62603                                                                                                              |
                                      Heap Blocks: exact=12851 lossy=33896                                                                                                       |
                                      ->  Bitmap Index Scan on ticket_2_start_date_idx  (cost=0.00..5365.01 rows=406056 width=0) (actual time=31.174..31.174 rows=374977 loops=1)|
                                            Index Cond: ((start_date >= ((CURRENT_DATE - '7 days'::interval))::date) AND (start_date <= CURRENT_DATE))                           |
Planning Time: 0.180 ms                                                                                                                                                          |
JIT:                                                                                                                                                                             |
  Functions: 43                                                                                                                                                                  |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                  |
  Timing: Generation 3.496 ms, Inlining 0.000 ms, Optimization 1.454 ms, Emission 29.691 ms, Total 34.642 ms                                                                     |
Execution Time: 1098.613 ms                                                                                                                                                      |                                                                                                                                                |                                                                                                                                                                    |
```

Проверим выборку по полю типа `timestamp`
```sql
EXPLAIN ANALYZE
select t.movie_id, count(t.id) as cnt, sum(t.price) as price from ticket_2 t
where
    t.status = 1 AND
    t.start_timestamp  between (CURRENT_DATE - interval '1 WEEK') and CURRENT_DATE
group by t.movie_id
order by price desc
limit 3
```

Результат
```
QUERY PLAN                                                                                                                                                                            |
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=276672.63..276672.64 rows=3 width=56) (actual time=982.157..984.793 rows=3 loops=1)                                                                                      |
  ->  Sort  (cost=276672.63..277071.93 rows=159719 width=56) (actual time=970.945..973.581 rows=3 loops=1)                                                                            |
        Sort Key: (sum(price)) DESC                                                                                                                                                   |
        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                                     |
        ->  Finalize GroupAggregate  (cost=254266.22..274608.30 rows=159719 width=56) (actual time=716.012..935.748 rows=145432 loops=1)                                              |
              Group Key: movie_id                                                                                                                                                     |
              ->  Gather Merge  (cost=254266.22..271269.53 rows=134228 width=56) (actual time=715.995..808.581 rows=145973 loops=1)                                                   |
                    Workers Planned: 2                                                                                                                                                |
                    Workers Launched: 2                                                                                                                                               |
                    ->  Partial GroupAggregate  (cost=253266.20..254776.26 rows=67114 width=56) (actual time=702.791..743.412 rows=48658 loops=3)                                     |
                          Group Key: movie_id                                                                                                                                         |
                          ->  Sort  (cost=253266.20..253433.98 rows=67114 width=37) (actual time=702.749..710.356 rows=54641 loops=3)                                                 |
                                Sort Key: movie_id                                                                                                                                    |
                                Sort Method: external merge  Disk: 2616kB                                                                                                             |
                                Worker 0:  Sort Method: external merge  Disk: 2480kB                                                                                                  |
                                Worker 1:  Sort Method: external merge  Disk: 2464kB                                                                                                  |
                                ->  Parallel Bitmap Heap Scan on ticket_2 t  (cost=7809.35..246048.06 rows=67114 width=37) (actual time=47.041..672.811 rows=54641 loops=3)           |
                                      Recheck Cond: ((start_timestamp >= (CURRENT_DATE - '7 days'::interval)) AND (start_timestamp <= CURRENT_DATE))                                  |
                                      Rows Removed by Index Recheck: 2063536                                                                                                          |
                                      Filter: (status = 1)                                                                                                                            |
                                      Rows Removed by Filter: 54946                                                                                                                   |
                                      Heap Blocks: exact=11237 lossy=34049                                                                                                            |
                                      ->  Bitmap Index Scan on ticket_2_start_timestamp_idx  (cost=0.00..7769.08 rows=320864 width=0) (actual time=43.336..43.337 rows=328760 loops=1)|
                                            Index Cond: ((start_timestamp >= (CURRENT_DATE - '7 days'::interval)) AND (start_timestamp <= CURRENT_DATE))                              |
Planning Time: 0.161 ms                                                                                                                                                               |
JIT:                                                                                                                                                                                  |
  Functions: 43                                                                                                                                                                       |
  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                       |
  Timing: Generation 3.266 ms, Inlining 0.000 ms, Optimization 1.461 ms, Emission 29.051 ms, Total 33.778 ms                                                                          |
Execution Time: 986.505 ms                                                                                                                                                            |
```

Итого получается, что выборка по полю типа `timestamp` быстрее

Добавим к запросам `join` для имени фильма:

```sql
EXPLAIN ANALYZE
select m.name, count(t.id) as cnt, sum(t.price) as price from ticket_2 t
left join movie m on t.movie_id=m.id
where
    t.status = 1 AND
    t.start_date between (CURRENT_DATE - interval '1 WEEK')::date and CURRENT_DATE::date
group by m.name
order by price desc
limit 3
```
Результат
```
QUERY PLAN                                                                                                                                                                             |
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=592195.28..592195.29 rows=3 width=61) (actual time=1351.728..1353.378 rows=3 loops=1)                                                                                     |
  ->  Sort  (cost=592195.28..592704.88 rows=203840 width=61) (actual time=1123.192..1124.841 rows=3 loops=1)                                                                           |
        Sort Key: (sum(t.price)) DESC                                                                                                                                                  |
        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                                      |
        ->  Finalize GroupAggregate  (cost=563796.28..589560.69 rows=203840 width=61) (actual time=1089.983..1124.611 rows=755 loops=1)                                                |
              Group Key: m.name                                                                                                                                                        |
              ->  Gather Merge  (cost=563796.28..585314.03 rows=169866 width=61) (actual time=1089.946..1123.595 rows=1324 loops=1)                                                    |
                    Workers Planned: 2                                                                                                                                                 |
                    Workers Launched: 2                                                                                                                                                |
                    ->  Partial GroupAggregate  (cost=562796.26..564707.25 rows=84933 width=61) (actual time=1074.133..1093.092 rows=441 loops=3)                                      |
                          Group Key: m.name                                                                                                                                            |
                          ->  Sort  (cost=562796.26..563008.59 rows=84933 width=42) (actual time=1074.091..1082.960 rows=62390 loops=3)                                                |
                                Sort Key: m.name                                                                                                                                       |
                                Sort Method: external merge  Disk: 2456kB                                                                                                              |
                                Worker 0:  Sort Method: external merge  Disk: 1864kB                                                                                                   |
                                Worker 1:  Sort Method: external merge  Disk: 1824kB                                                                                                   |
                                ->  Nested Loop Left Join  (cost=5416.40..553228.28 rows=84933 width=42) (actual time=179.000..1046.612 rows=62390 loops=3)                            |
                                      ->  Parallel Bitmap Heap Scan on ticket_2 t  (cost=5415.97..252198.79 rows=84933 width=37) (actual time=178.938..781.059 rows=62390 loops=3)     |
                                            Recheck Cond: ((start_date >= ((CURRENT_DATE - '7 days'::interval))::date) AND (start_date <= CURRENT_DATE))                               |
                                            Rows Removed by Index Recheck: 2055112                                                                                                     |
                                            Filter: (status = 1)                                                                                                                       |
                                            Rows Removed by Filter: 62603                                                                                                              |
                                            Heap Blocks: exact=14872 lossy=39533                                                                                                       |
                                            ->  Bitmap Index Scan on ticket_2_start_date_idx  (cost=0.00..5365.01 rows=406056 width=0) (actual time=29.230..29.230 rows=374977 loops=1)|
                                                  Index Cond: ((start_date >= ((CURRENT_DATE - '7 days'::interval))::date) AND (start_date <= CURRENT_DATE))                           |
                                      ->  Index Scan using movie_pk on movie m  (cost=0.43..3.54 rows=1 width=37) (actual time=0.004..0.004 rows=0 loops=187169)                       |
                                            Index Cond: (id = t.movie_id)                                                                                                              |
Planning Time: 0.393 ms                                                                                                                                                                |
JIT:                                                                                                                                                                                   |
  Functions: 55                                                                                                                                                                        |
  Options: Inlining true, Optimization true, Expressions true, Deforming true                                                                                                          |
  Timing: Generation 4.172 ms, Inlining 161.531 ms, Optimization 307.893 ms, Emission 212.568 ms, Total 686.164 ms                                                                     |
Execution Time: 1355.270 ms                                                                                                                                                            |
```


```sql
EXPLAIN ANALYZE
select m.name, count(t.id) as cnt, sum(t.price) as price from ticket_2 t
left join movie m on t.movie_id=m.id
where
    t.status = 1 AND
    t.start_timestamp  between (CURRENT_DATE - interval '1 WEEK') and CURRENT_DATE
group by m.name
order by price desc
limit 3
```

Результат
```
QUERY PLAN                                                                                                                                                                                  |
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=543279.75..543279.76 rows=3 width=61) (actual time=1217.867..1219.500 rows=3 loops=1)                                                                                          |
  ->  Sort  (cost=543279.75..543682.44 rows=161074 width=61) (actual time=1008.764..1010.396 rows=3 loops=1)                                                                                |
        Sort Key: (sum(t.price)) DESC                                                                                                                                                       |
        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                                           |
        ->  Finalize GroupAggregate  (cost=520838.89..541197.90 rows=161074 width=61) (actual time=979.076..1010.198 rows=664 loops=1)                                                      |
              Group Key: m.name                                                                                                                                                             |
              ->  Gather Merge  (cost=520838.89..537842.19 rows=134228 width=61) (actual time=979.047..1009.307 rows=1160 loops=1)                                                          |
                    Workers Planned: 2                                                                                                                                                      |
                    Workers Launched: 2                                                                                                                                                     |
                    ->  Partial GroupAggregate  (cost=519838.86..521348.93 rows=67114 width=61) (actual time=963.928..980.413 rows=387 loops=3)                                             |
                          Group Key: m.name                                                                                                                                                 |
                          ->  Sort  (cost=519838.86..520006.65 rows=67114 width=42) (actual time=963.881..971.677 rows=54641 loops=3)                                                       |
                                Sort Key: m.name                                                                                                                                            |
                                Sort Method: external merge  Disk: 2184kB                                                                                                                   |
                                Worker 0:  Sort Method: external merge  Disk: 1608kB                                                                                                        |
                                Worker 1:  Sort Method: external merge  Disk: 1600kB                                                                                                        |
                                ->  Nested Loop Left Join  (cost=7809.79..512393.22 rows=67114 width=42) (actual time=187.781..939.524 rows=54641 loops=3)                                  |
                                      ->  Parallel Bitmap Heap Scan on ticket_2 t  (cost=7809.35..246048.06 rows=67114 width=37) (actual time=187.723..705.959 rows=54641 loops=3)          |
                                            Recheck Cond: ((start_timestamp >= (CURRENT_DATE - '7 days'::interval)) AND (start_timestamp <= CURRENT_DATE))                                  |
                                            Rows Removed by Index Recheck: 2063536                                                                                                          |
                                            Filter: (status = 1)                                                                                                                            |
                                            Rows Removed by Filter: 54946                                                                                                                   |
                                            Heap Blocks: exact=13261 lossy=40033                                                                                                            |
                                            ->  Bitmap Index Scan on ticket_2_start_timestamp_idx  (cost=0.00..7769.08 rows=320864 width=0) (actual time=41.464..41.464 rows=328760 loops=1)|
                                                  Index Cond: ((start_timestamp >= (CURRENT_DATE - '7 days'::interval)) AND (start_timestamp <= CURRENT_DATE))                              |
                                      ->  Index Scan using movie_pk on movie m  (cost=0.43..3.97 rows=1 width=37) (actual time=0.004..0.004 rows=0 loops=163923)                            |
                                            Index Cond: (id = t.movie_id)                                                                                                                   |
Planning Time: 0.437 ms                                                                                                                                                                     |
JIT:                                                                                                                                                                                        |
  Functions: 55                                                                                                                                                                             |
  Options: Inlining true, Optimization true, Expressions true, Deforming true                                                                                                               |
  Timing: Generation 3.936 ms, Inlining 161.105 ms, Optimization 300.623 ms, Emission 196.002 ms, Total 661.666 ms                                                                          |
Execution Time: 1221.207 ms                                                                                                                                                                 |
```

Итого разница между `date` и `timestamp` небольшая (`~100 ms`). Все ускорение только за счет отказа от `join`.
