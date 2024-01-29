
# 1. Выбор всех фильмов на сегодня
## Запрос:
```sql
SELECT DISTINCT f.name as film
FROM seance s
     JOIN public.film f
          on f.id = s.film_id
WHERE s.date::date = CURRENT_DATE;
```

## план на БД до 10000 строк:
```
Unique  (cost=561.54..561.79 rows=50 width=44)
  ->  Sort  (cost=561.54..561.66 rows=50 width=44)
        Sort Key: f.name
        ->  Nested Loop  (cost=0.29..560.13 rows=50 width=44)
              ->  Seq Scan on seance s  (cost=0.00..249.00 rows=50 width=8)
                    Filter: ((date)::date = CURRENT_DATE)
              ->  Index Scan using film_pkey on film f  (cost=0.29..6.22 rows=1 width=52)
                    Index Cond: (id = s.film_id)
```

## план на БД до 10000000 строк:
```
HashAggregate  (cost=338887.85..339429.51 rows=54166 width=44) (actual time=1102.072..1201.563 rows=285557 loops=1)
  Group Key: f.name
  Batches: 21  Memory Usage: 8249kB  Disk Usage: 15856kB
  ->  Gather  (cost=333065.01..338752.44 rows=54166 width=44) (actual time=1000.337..1036.494 rows=288239 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  HashAggregate  (cost=332065.01..332335.84 rows=27083 width=44) (actual time=989.079..1012.927 rows=96080 loops=3)
              Group Key: f.name
              Batches: 5  Memory Usage: 8497kB  Disk Usage: 3608kB
              Worker 0:  Batches: 5  Memory Usage: 8753kB  Disk Usage: 3568kB
              Worker 1:  Batches: 5  Memory Usage: 8753kB  Disk Usage: 3528kB
              ->  Nested Loop  (cost=0.43..331997.30 rows=27083 width=44) (actual time=5.985..942.243 rows=96547 loops=3)
                    ->  Parallel Seq Scan on seance s  (cost=0.00..176839.00 rows=27083 width=8) (actual time=5.917..396.442 rows=96547 loops=3)
                          Filter: ((date)::date = '2024-01-22'::date)
                          Rows Removed by Filter: 4236787
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=289640)
                          Index Cond: (id = s.film_id)
Planning Time: 0.196 ms
JIT:
  Functions: 49
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.252 ms, Inlining 0.000 ms, Optimization 1.513 ms, Emission 22.059 ms, Total 25.824 ms"
Execution Time: 1210.272 ms

```

Меняет настройки сервера:
```
postgres -c work_mem=16MB -c shared_buffers=1024MB
```

EXPLAIN ANALYSE:
```
HashAggregate  (cost=338887.85..339429.51 rows=54166 width=44) (actual time=976.924..1028.461 rows=284866 loops=1)
  Group Key: f.name
  Batches: 5  Memory Usage: 32817kB  Disk Usage: 7432kB
  ->  Gather  (cost=333065.01..338752.44 rows=54166 width=44) (actual time=849.695..869.833 rows=287534 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  HashAggregate  (cost=332065.01..332335.84 rows=27083 width=44) (actual time=838.451..847.415 rows=95845 loops=3)
              Group Key: f.name
              Batches: 1  Memory Usage: 17425kB
              Worker 0:  Batches: 1  Memory Usage: 13329kB
              Worker 1:  Batches: 1  Memory Usage: 13329kB
              ->  Nested Loop  (cost=0.43..331997.30 rows=27083 width=44) (actual time=6.088..800.200 rows=96316 loops=3)
                    ->  Parallel Seq Scan on seance s  (cost=0.00..176839.00 rows=27083 width=8) (actual time=6.030..359.810 rows=96316 loops=3)
                          Filter: ((date)::date = '2024-01-22'::date)
                          Rows Removed by Filter: 4237018
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.004..0.004 rows=1 loops=288947)
                          Index Cond: (id = s.film_id)
Planning Time: 0.252 ms
JIT:
  Functions: 43
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.196 ms, Inlining 0.000 ms, Optimization 1.167 ms, Emission 18.338 ms, Total 21.700 ms"
Execution Time: 1036.591 ms

```

Время запроса уменьшилось примерно на 200 мс.

Ни один индекс для timestamptz не уменьшает время запроса.

# 2. Подсчёт проданных билетов за неделю
## Запрос:
```sql
SELECT count(1)
FROM ticket t
WHERE t.date::date >= CURRENT_DATE
  AND t.date::date <= CURRENT_DATE + INTERVAL '7 days';
```

## план на БД до 10000 строк:
```
Aggregate  (cost=349.13..349.14 rows=1 width=8)
  ->  Seq Scan on ticket t  (cost=0.00..349.00 rows=50 width=0)
        Filter: (((date)::date >= CURRENT_DATE) AND ((date)::date <= (CURRENT_DATE + '7 days'::interval)))

```

## план на БД до 10000000 строк:
```
Finalize Aggregate  (cost=157915.63..157915.64 rows=1 width=8) (actual time=400.536..403.327 rows=1 loops=1)
  ->  Gather  (cost=157915.42..157915.63 rows=2 width=8) (actual time=400.373..403.311 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=156915.42..156915.43 rows=1 width=8) (actual time=389.885..389.886 rows=1 loops=3)
              ->  Parallel Seq Scan on ticket t  (cost=0.00..156863.33 rows=20833 width=0) (actual time=2.990..369.478 rows=703236 loops=3)
                    Filter: (((date)::date >= '2024-01-22'::date) AND ((date)::date <= '2024-01-29 00:00:00'::timestamp without time zone))
                    Rows Removed by Filter: 2630097
Planning Time: 0.057 ms
JIT:
  Functions: 14
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.911 ms, Inlining 0.000 ms, Optimization 0.469 ms, Emission 8.507 ms, Total 9.887 ms"
Execution Time: 403.667 ms
```

Добавляем индекс и в запросе указыввем тайм зону
```sql
CREATE INDEX CONCURRENTLY IF NOT EXISTS ticket_date__ind ON ticket(date(timezone('UTC', date)));

SELECT count(1)
FROM ticket t
WHERE date(timezone('UTC', date)) >= '2024.01.22'
  AND date(timezone('UTC', date)) <= '2024.01.22'::date + INTERVAL '7 days';
```

План:
```
Aggregate  (cost=71572.18..71572.19 rows=1 width=8) (actual time=226.550..226.551 rows=1 loops=1)
  ->  Bitmap Heap Scan on ticket t  (cost=684.93..71447.18 rows=50000 width=0) (actual time=48.624..170.600 rows=2111178 loops=1)
"        Recheck Cond: ((date(timezone('UTC'::text, date)) >= '2024-01-22'::date) AND (date(timezone('UTC'::text, date)) <= '2024-01-29 00:00:00'::timestamp without time zone))"
        Heap Blocks: exact=73530
        ->  Bitmap Index Scan on ticket_date__ind  (cost=0.00..672.43 rows=50000 width=0) (actual time=39.678..39.679 rows=2111178 loops=1)
"              Index Cond: ((date(timezone('UTC'::text, date)) >= '2024-01-22'::date) AND (date(timezone('UTC'::text, date)) <= '2024-01-29 00:00:00'::timestamp without time zone))"
Planning Time: 0.056 ms
Execution Time: 226.697 ms
```

Время выполнения запроса уменьшено в 1,8 раза с использованием индекса.

&nbsp;

# 3. Формирование афиши (фильмы, которые показывают сегодня)
## Запрос:
```sql
SELECT f.name as film,
       h.name,
       s.date::time
FROM seance s
     JOIN public.film f
          on f.id = s.film_id
     JOIN public.hall h
          on h.id = s.hall_id
WHERE s.date::date = CURRENT_DATE
ORDER BY s.date;
```

## план на БД до 10000 строк:
```
Sort  (cost=601.31..601.43 rows=50 width=67)
  Sort Key: s.date
  ->  Nested Loop  (cost=250.98..599.90 rows=50 width=67)
        ->  Merge Join  (cost=250.70..288.65 rows=50 width=23)
              Merge Cond: (h.id = s.hall_id)
              ->  Index Scan using hall_pkey on hall h  (cost=0.29..347.29 rows=10000 width=15)
              ->  Sort  (cost=250.41..250.54 rows=50 width=24)
                    Sort Key: s.hall_id
                    ->  Seq Scan on seance s  (cost=0.00..249.00 rows=50 width=24)
                          Filter: ((date)::date = CURRENT_DATE)
        ->  Index Scan using film_pkey on film f  (cost=0.29..6.22 rows=1 width=52)
              Index Cond: (id = s.film_id)

```

## план на БД до 10000000 строк:
```
Gather Merge  (cost=470950.90..477270.71 rows=54166 width=70) (actual time=1538.334..1589.569 rows=289640 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=469950.87..470018.58 rows=27083 width=70) (actual time=1526.479..1539.055 rows=96547 loops=3)
        Sort Key: s.date
        Sort Method: external merge  Disk: 8160kB
        Worker 0:  Sort Method: external merge  Disk: 7960kB
        Worker 1:  Sort Method: external merge  Disk: 7968kB
        ->  Nested Loop  (cost=0.87..467956.88 rows=27083 width=70) (actual time=7.017..1491.050 rows=96547 loops=3)
              ->  Nested Loop  (cost=0.43..331997.30 rows=27083 width=60) (actual time=6.979..953.249 rows=96547 loops=3)
                    ->  Parallel Seq Scan on seance s  (cost=0.00..176839.00 rows=27083 width=24) (actual time=6.909..386.274 rows=96547 loops=3)
                          Filter: ((date)::date = '2024-01-22'::date)
                          Rows Removed by Filter: 4236787
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.006..0.006 rows=1 loops=289640)
                          Index Cond: (id = s.film_id)
              ->  Index Scan using hall_pkey on hall h  (cost=0.43..5.02 rows=1 width=18) (actual time=0.005..0.005 rows=1 loops=289640)
                    Index Cond: (id = s.hall_id)
Planning Time: 0.423 ms
JIT:
  Functions: 39
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.911 ms, Inlining 0.000 ms, Optimization 0.910 ms, Emission 19.762 ms, Total 22.584 ms"
Execution Time: 1598.460 ms
```

Добавляем индекс и таймзону
```sql
CREATE INDEX CONCURRENTLY IF NOT EXISTS seance_date__ind ON seance( date(timezone('UTC', date)));

SELECT f.name as film,
       h.name,
       s.date::time
FROM seance s
     JOIN public.film f
          on f.id = s.film_id
     JOIN public.hall h
          on h.id = s.hall_id
WHERE date(timezone('UTC', s.date)) = '2024.01.22'
ORDER BY s.date;
```


EXPLAIN ANALYSE:
```
Gather Merge  (cost=385679.80..391999.61 rows=54166 width=70) (actual time=1082.239..1112.344 rows=288947 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=384679.78..384747.49 rows=27083 width=70) (actual time=1070.785..1073.283 rows=96316 loops=3)
        Sort Key: s.date
        Sort Method: quicksort  Memory: 14292kB
        Worker 0:  Sort Method: quicksort  Memory: 13209kB
        Worker 1:  Sort Method: quicksort  Memory: 13392kB
        ->  Nested Loop  (cost=729.05..382685.78 rows=27083 width=70) (actual time=21.552..1050.372 rows=96316 loops=3)
              ->  Nested Loop  (cost=728.62..246726.20 rows=27083 width=60) (actual time=21.501..614.503 rows=96316 loops=3)
                    ->  Parallel Bitmap Heap Scan on seance s  (cost=728.18..91567.90 rows=27083 width=24) (actual time=15.938..118.201 rows=96316 loops=3)
"                          Recheck Cond: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
                          Heap Blocks: exact=32271
                          ->  Bitmap Index Scan on seance_date__ind  (cost=0.00..711.93 rows=65000 width=0) (actual time=15.517..15.517 rows=288947 loops=1)
"                                Index Cond: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=288947)
                          Index Cond: (id = s.film_id)
              ->  Index Scan using hall_pkey on hall h  (cost=0.43..5.02 rows=1 width=18) (actual time=0.004..0.004 rows=1 loops=288947)
                    Index Cond: (id = s.hall_id)
Planning Time: 0.301 ms
JIT:
  Functions: 39
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.918 ms, Inlining 0.000 ms, Optimization 0.970 ms, Emission 15.588 ms, Total 18.476 ms"
Execution Time: 1120.233 ms
```

Время выполнения запроса ускорено в 1,4 раза.
&nbsp;

# 4. Поиск 3 самых прибыльных фильмов за неделю
## Запрос:
```sql
SELECT f.name,
       SUM(p.price) as "price"
FROM ticket t
     JOIN public.price p
          on p.id = t.price
     JOIN public.seance s
          on s.id = p.seance_id
     JOIN public.film f
          on f.id = s.film_id
WHERE t.date::date >= CURRENT_DATE
  AND t.date::date <= CURRENT_DATE + INTERVAL '7 days'
GROUP BY f.name
ORDER BY price DESC
LIMIT 3;
```

## план на БД до 10000 строк:
```
Limit  (cost=603.27..603.28 rows=3 width=76)
  ->  Sort  (cost=603.27..603.40 rows=50 width=76)
        Sort Key: (sum(p.price)) DESC
        ->  GroupAggregate  (cost=601.63..602.63 rows=50 width=76)
              Group Key: f.name
              ->  Sort  (cost=601.63..601.75 rows=50 width=49)
                    Sort Key: f.name
                    ->  Nested Loop  (cost=350.20..600.22 rows=50 width=49)
                          ->  Nested Loop  (cost=349.91..578.83 rows=50 width=13)
                                ->  Hash Join  (cost=349.63..561.62 rows=50 width=13)
                                      Hash Cond: (p.id = t.price)
                                      ->  Seq Scan on price p  (cost=0.00..174.00 rows=10000 width=21)
                                      ->  Hash  (cost=349.00..349.00 rows=50 width=8)
                                            ->  Seq Scan on ticket t  (cost=0.00..349.00 rows=50 width=8)
                                                  Filter: (((date)::date >= CURRENT_DATE) AND ((date)::date <= (CURRENT_DATE + '7 days'::interval)))
                                ->  Index Scan using seance_pkey on seance s  (cost=0.29..0.34 rows=1 width=16)
                                      Index Cond: (id = p.seance_id)
                          ->  Index Scan using film_pkey on film f  (cost=0.29..0.43 rows=1 width=52)
                                Index Cond: (id = s.film_id)

```

## план на БД до 10000000 строк:
```
Limit  (cost=322672.21..322672.22 rows=3 width=76) (actual time=9440.077..9460.608 rows=3 loops=1)
  ->  Sort  (cost=322672.21..322797.21 rows=50000 width=76) (actual time=9431.228..9451.759 rows=3 loops=1)
        Sort Key: (sum(p.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=315862.53..322025.97 rows=50000 width=76) (actual time=7342.234..9321.318 rows=838288 loops=1)
              Group Key: f.name
              ->  Gather Merge  (cost=315862.53..321088.48 rows=41666 width=76) (actual time=7342.221..8247.468 rows=1474040 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=314862.50..315279.16 rows=20833 width=76) (actual time=7325.158..7861.281 rows=491347 loops=3)
                          Group Key: f.name
                          ->  Sort  (cost=314862.50..314914.59 rows=20833 width=49) (actual time=7325.127..7611.947 rows=703726 loops=3)
                                Sort Key: f.name
                                Sort Method: external merge  Disk: 41272kB
                                Worker 0:  Sort Method: external merge  Disk: 40784kB
                                Worker 1:  Sort Method: external merge  Disk: 40960kB
                                ->  Nested Loop  (cost=1.30..313368.09 rows=20833 width=49) (actual time=5.650..6025.419 rows=703726 loops=3)
                                      ->  Nested Loop  (cost=0.87..293338.18 rows=20833 width=13) (actual time=5.615..3130.687 rows=703726 loops=3)
                                            ->  Nested Loop  (cost=0.43..271803.58 rows=20833 width=13) (actual time=5.584..1340.871 rows=703726 loops=3)
                                                  ->  Parallel Seq Scan on ticket t  (cost=0.00..156863.33 rows=20833 width=8) (actual time=5.528..410.509 rows=703726 loops=3)
                                                        Filter: (((date)::date >= '2024-01-22'::date) AND ((date)::date <= '2024-01-29 00:00:00'::timestamp without time zone))
                                                        Rows Removed by Filter: 2629607
                                                  ->  Index Scan using price_pkey on price p  (cost=0.43..5.52 rows=1 width=21) (actual time=0.001..0.001 rows=1 loops=2111178)
                                                        Index Cond: (id = t.price)
                                            ->  Index Scan using seance_pkey on seance s  (cost=0.43..1.03 rows=1 width=16) (actual time=0.002..0.002 rows=1 loops=2111178)
                                                  Index Cond: (id = p.seance_id)
                                      ->  Index Scan using film_pkey on film f  (cost=0.43..0.96 rows=1 width=52) (actual time=0.004..0.004 rows=1 loops=2111178)
                                            Index Cond: (id = s.film_id)
Planning Time: 0.669 ms
JIT:
  Functions: 70
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.664 ms, Inlining 0.000 ms, Optimization 1.087 ms, Emission 24.374 ms, Total 28.124 ms"
Execution Time: 9466.003 ms
```

Задаем таймзону для использования уже созданного индекса ticket_date__ind:
```sql
SELECT f.name,
       SUM(p.price) as "price"
FROM ticket t
     JOIN public.price p
          on p.id = t.price
     JOIN public.seance s
          on s.id = p.seance_id
     JOIN public.film f
          on f.id = s.film_id
WHERE date(timezone('UTC', t.date)) >= '2024.01.22'
  AND date(timezone('UTC', t.date)) <= '2024.01.22'::date + INTERVAL '7 days'
GROUP BY f.name
ORDER BY price DESC
LIMIT 3;
```

EXPLAIN ANALYSE:
```
Limit  (cost=236526.89..236526.90 rows=3 width=76) (actual time=9133.239..9156.858 rows=3 loops=1)
  ->  Sort  (cost=236526.89..236651.89 rows=50000 width=76) (actual time=9124.361..9147.979 rows=3 loops=1)
        Sort Key: (sum(p.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=229717.21..235880.65 rows=50000 width=76) (actual time=7015.494..9016.211 rows=838288 loops=1)
              Group Key: f.name
              ->  Gather Merge  (cost=229717.21..234943.16 rows=41666 width=76) (actual time=7015.484..7934.776 rows=1474600 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=228717.18..229133.84 rows=20833 width=76) (actual time=6986.154..7523.166 rows=491533 loops=3)
                          Group Key: f.name
                          ->  Sort  (cost=228717.18..228769.27 rows=20833 width=49) (actual time=6986.116..7273.165 rows=703726 loops=3)
                                Sort Key: f.name
                                Sort Method: external merge  Disk: 41776kB
                                Worker 0:  Sort Method: external merge  Disk: 40704kB
                                Worker 1:  Sort Method: external merge  Disk: 40536kB
                                ->  Nested Loop  (cost=686.24..227222.77 rows=20833 width=49) (actual time=48.656..5695.311 rows=703726 loops=3)
                                      ->  Nested Loop  (cost=685.80..207192.86 rows=20833 width=13) (actual time=48.615..2854.534 rows=703726 loops=3)
                                            ->  Nested Loop  (cost=685.37..185658.26 rows=20833 width=13) (actual time=48.590..1117.348 rows=703726 loops=3)
                                                  ->  Parallel Bitmap Heap Scan on ticket t  (cost=684.93..70718.01 rows=20833 width=8) (actual time=42.696..170.398 rows=703726 loops=3)
"                                                        Recheck Cond: ((date(timezone('UTC'::text, date)) >= '2024-01-22'::date) AND (date(timezone('UTC'::text, date)) <= '2024-01-29 00:00:00'::timestamp without time zone))"
                                                        Heap Blocks: exact=24997
                                                        ->  Bitmap Index Scan on ticket_date__ind  (cost=0.00..672.43 rows=50000 width=0) (actual time=44.907..44.907 rows=2111178 loops=1)
"                                                              Index Cond: ((date(timezone('UTC'::text, date)) >= '2024-01-22'::date) AND (date(timezone('UTC'::text, date)) <= '2024-01-29 00:00:00'::timestamp without time zone))"
                                                  ->  Index Scan using price_pkey on price p  (cost=0.43..5.52 rows=1 width=21) (actual time=0.001..0.001 rows=1 loops=2111178)
                                                        Index Cond: (id = t.price)
                                            ->  Index Scan using seance_pkey on seance s  (cost=0.43..1.03 rows=1 width=16) (actual time=0.002..0.002 rows=1 loops=2111178)
                                                  Index Cond: (id = p.seance_id)
                                      ->  Index Scan using film_pkey on film f  (cost=0.43..0.96 rows=1 width=52) (actual time=0.004..0.004 rows=1 loops=2111178)
                                            Index Cond: (id = s.film_id)
Planning Time: 0.426 ms
JIT:
  Functions: 70
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.749 ms, Inlining 0.000 ms, Optimization 1.142 ms, Emission 25.287 ms, Total 29.178 ms"
Execution Time: 9162.218 ms
```

Есть незначительное улучшение на 304мс. Оставляем так

&nbsp;

# 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
## Запрос:
```sql
SELECT h.name                                                   as "зал",
       pl.row                                                   as "ряд",
       pl.number                                                as "номер",
       CASE WHEN t.id IS NULL THEN 'свободно' ELSE 'занято' END as "статус"
FROM place pl
     join public.price pr
          on pl.id = pr.place_id
     JOIN public.hall h
          on h.id = pl.hall_id
     LEFT JOIN public.ticket t
               on pr.id = t.price
WHERE pr.seance_id = 1000
ORDER BY pl.row, pl.number;
```

## план на БД до 10000 строк:
```
Sort  (cost=416.59..416.60 rows=2 width=43)
"  Sort Key: pl.""row"", pl.number"
  ->  Nested Loop  (cost=199.59..416.58 rows=2 width=43)
        ->  Nested Loop  (cost=199.31..415.89 rows=2 width=20)
              ->  Hash Right Join  (cost=199.03..399.29 rows=2 width=16)
                    Hash Cond: (t.price = pr.id)
                    ->  Seq Scan on ticket t  (cost=0.00..174.00 rows=10000 width=16)
                    ->  Hash  (cost=199.00..199.00 rows=2 width=16)
                          ->  Seq Scan on price pr  (cost=0.00..199.00 rows=2 width=16)
                                Filter: (seance_id = 1000)
              ->  Index Scan using place_pkey on place pl  (cost=0.29..8.30 rows=1 width=20)
                    Index Cond: (id = pr.place_id)
        ->  Index Scan using hall_pkey on hall h  (cost=0.29..0.34 rows=1 width=15)
              Index Cond: (id = pl.hall_id)

```

## план на БД до 10000000 строк:
```
Sort  (cost=326484.13..326484.15 rows=10 width=46) (actual time=1057.415..1057.494 rows=12 loops=1)
"  Sort Key: pl.""row"", pl.number"
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=126615.33..326483.96 rows=10 width=46) (actual time=143.864..1057.418 rows=12 loops=1)
        ->  Nested Loop  (cost=126614.89..326478.99 rows=10 width=20) (actual time=143.845..1057.240 rows=12 loops=1)
              ->  Hash Right Join  (cost=126614.46..326394.47 rows=10 width=16) (actual time=143.801..1038.582 rows=12 loops=1)
                    Hash Cond: (t.price = pr.id)
                    ->  Seq Scan on ticket t  (cost=0.00..173530.00 rows=10000000 width=16) (actual time=0.014..442.884 rows=10000000 loops=1)
                    ->  Hash  (cost=126614.33..126614.33 rows=10 width=16) (actual time=142.895..142.972 rows=12 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Gather  (cost=1000.00..126614.33 rows=10 width=16) (actual time=14.361..142.945 rows=12 loops=1)
                                Workers Planned: 2
                                Workers Launched: 2
                                ->  Parallel Seq Scan on price pr  (cost=0.00..125613.33 rows=4 width=16) (actual time=13.291..132.272 rows=4 loops=3)
                                      Filter: (seance_id = 1000)
                                      Rows Removed by Filter: 3333329
              ->  Index Scan using place_pkey on place pl  (cost=0.43..8.45 rows=1 width=20) (actual time=1.548..1.548 rows=1 loops=12)
                    Index Cond: (id = pr.place_id)
        ->  Index Scan using hall_pkey on hall h  (cost=0.43..0.50 rows=1 width=18) (actual time=0.012..0.012 rows=1 loops=12)
              Index Cond: (id = pl.hall_id)
Planning Time: 1.057 ms
JIT:
  Functions: 31
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.701 ms, Inlining 0.000 ms, Optimization 0.902 ms, Emission 18.283 ms, Total 20.886 ms"
Execution Time: 1058.813 ms
```


Добавляем индексы:
```
CREATE INDEX CONCURRENTLY IF NOT EXISTS price_seance_id__ind ON price(seance_id);
CREATE INDEX CONCURRENTLY IF NOT EXISTS ticket_price_id__ind ON ticket(price);
```

EXPLAIN ANALYSE:
```
Sort  (cost=240.34..240.37 rows=11 width=46) (actual time=0.233..0.234 rows=12 loops=1)
"  Sort Key: pl.""row"", pl.number"
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop Left Join  (cost=1.74..240.15 rows=11 width=46) (actual time=0.048..0.222 rows=12 loops=1)
        ->  Nested Loop  (cost=1.30..147.07 rows=11 width=22) (actual time=0.038..0.150 rows=12 loops=1)
              ->  Nested Loop  (cost=0.87..141.60 rows=11 width=20) (actual time=0.029..0.088 rows=12 loops=1)
                    ->  Index Scan using price_seance_id__ind on price pr  (cost=0.43..48.62 rows=11 width=16) (actual time=0.013..0.024 rows=12 loops=1)
                          Index Cond: (seance_id = 1000)
                    ->  Index Scan using place_pkey on place pl  (cost=0.43..8.45 rows=1 width=20) (actual time=0.005..0.005 rows=1 loops=12)
                          Index Cond: (id = pr.place_id)
              ->  Index Scan using hall_pkey on hall h  (cost=0.43..0.50 rows=1 width=18) (actual time=0.005..0.005 rows=1 loops=12)
                    Index Cond: (id = pl.hall_id)
        ->  Index Scan using ticket_price_id__ind on ticket t  (cost=0.43..8.45 rows=1 width=16) (actual time=0.005..0.006 rows=1 loops=12)
              Index Cond: (price = pr.id)
Planning Time: 0.510 ms
Execution Time: 0.303 ms
```
Стоимость сократилась в разы. Оставляем индексы
&nbsp;

# 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
## Запрос:
```sql
SELECT MIN(pr.price) || ' - ' || MAX(pr.price) as price_range
FROM price pr
WHERE pr.seance_id = 1000
GROUP BY pr.seance_id
```

## план на БД до 10000 строк:
```
GroupAggregate  (cost=0.00..199.06 rows=2 width=40)
  Group Key: seance_id
  ->  Seq Scan on price pr  (cost=0.00..199.00 rows=2 width=13)
        Filter: (seance_id = 1000)

```

## план на БД до 10000000 строк:
```
Finalize GroupAggregate  (cost=1000.00..126614.51 rows=10 width=40) (actual time=141.307..144.513 rows=1 loops=1)
  Group Key: seance_id
  ->  Gather  (cost=1000.00..126614.20 rows=8 width=72) (actual time=141.077..144.493 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial GroupAggregate  (cost=0.00..125613.40 rows=4 width=72) (actual time=130.000..130.001 rows=1 loops=3)
              Group Key: seance_id
              ->  Parallel Seq Scan on price pr  (cost=0.00..125613.33 rows=4 width=13) (actual time=30.504..129.942 rows=4 loops=3)
                    Filter: (seance_id = 1000)
                    Rows Removed by Filter: 3333329
Planning Time: 0.173 ms
JIT:
  Functions: 24
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.434 ms, Inlining 0.000 ms, Optimization 0.856 ms, Emission 17.358 ms, Total 19.648 ms"
Execution Time: 145.105 ms
```

EXPLAIN ANALYSE:
```
GroupAggregate  (cost=0.43..48.98 rows=11 width=40) (actual time=0.065..0.065 rows=1 loops=1)
  Group Key: seance_id
  ->  Index Scan using price_seance_id__ind on price pr  (cost=0.43..48.62 rows=11 width=13) (actual time=0.039..0.051 rows=12 loops=1)
        Index Cond: (seance_id = 1000)
Planning Time: 0.088 ms
Execution Time: 0.117 ms
```

Время запроса уменьшено за счет ранее созданного индекса **price_seance_id__ind**

&nbsp;

# Метаданные
##  15 самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
### Запрос:
```sql
SELECT nspname || '.' || relname                     as name,
       pg_size_pretty(pg_total_relation_size(C.oid)) as total_size,
       pg_size_pretty(pg_relation_size(C.oid))       as real_size
FROM pg_class C
     LEFT JOIN pg_namespace N
               ON (N.oid = C.relnamespace)
WHERE nspname NOT IN ('pg_catalog', 'information_schema')
ORDER BY pg_total_relation_size(C.oid) DESC
LIMIT 15;
```

### 10000 строк:
```
public.client,3520 kB,1704 kB
public.film,2544 kB,2264 kB
public.client_email_key,1152 kB,1152 kB
public.hall,872 kB,592 kB
public.price,864 kB,592 kB
public.place,864 kB,592 kB
public.ticket,864 kB,592 kB
public.seance,864 kB,592 kB
pg_toast.pg_toast_2618,560 kB,512 kB
public.client_phone_key,384 kB,384 kB
public.seance_pkey,240 kB,240 kB
public.client_pkey,240 kB,240 kB
public.ticket_pkey,240 kB,240 kB
public.place_pkey,240 kB,240 kB
public.film_pkey,240 kB,240 kB
```

### 10000000 строк:
```
public.client,5008 MB,2276 MB
public.film,2432 MB,2217 MB
public.client_email_key,1990 MB,1990 MB
public.seance,1111 MB,747 MB
public.ticket,1069 MB,574 MB
public.price,877 MB,574 MB
public.hall,865 MB,651 MB
public.place,789 MB,574 MB
public.client_phone_key,527 MB,527 MB
public.seance_pkey,278 MB,278 MB
public.ticket_price_id__ind,214 MB,214 MB
public.client_pkey,214 MB,214 MB
public.hall_pkey,214 MB,214 MB
public.film_pkey,214 MB,214 MB
public.price_pkey,214 MB,214 MB
```
&nbsp;

## 5 часто используемых индексов
### Запрос:
```sql
SELECT * FROM pg_stat_user_indexes
ORDER BY idx_scan DESC , idx_tup_read DESC , idx_tup_fetch DESC
LIMIT 5;
```

### 10000 строк:
```
16617,16622,public,hall,hall_pkey,20013,21009,21000
16610,16615,public,film,film_pkey,12793,12793,12779
16645,16648,public,seance,seance_pkey,12089,12088,12080
16624,16627,public,place,place_pkey,10031,10031,10003
16660,16663,public,price,price_pkey,10022,10022,10000

```

### 10000000 строк:
```
16771,16776,public,film,film_pkey,62175168,72175165,62175021
16821,16824,public,price,price_pkey,43778930,43778930,43778848
16806,16809,public,seance,seance_pkey,43778880,43778880,43778848
16778,16783,public,hall,hall_pkey,25600667,25600667,25600631
16785,16788,public,place,place_pkey,10000126,10000126,10000108
```
&nbsp;

## 5 редко используемых индексов
### Запрос:
```sql
SELECT * FROM pg_stat_user_indexes
ORDER BY idx_scan , idx_tup_read , idx_tup_fetch
LIMIT 5;
```

### 10000 строк:
```
16675,16678,public,ticket,ticket_pkey,0,0,0
16634,16641,public,client,client_email_key,0,0,0
16634,16643,public,client,client_phone_key,0,0,0
16634,16639,public,client,client_pkey,10000,10000,10000
16660,16663,public,price,price_pkey,10022,10022,10000
```

### 10000000 строк:
```
16795,16804,public,client,client_phone_key,0,0,0
16836,16839,public,ticket,ticket_pkey,0,0,0
16795,16802,public,client,client_email_key,0,0,0
16806,16870,public,seance,seance_date__ind,3,866841,0
16821,16872,public,price,price_seance_id__ind,7,84,84
```
