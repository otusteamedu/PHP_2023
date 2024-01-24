
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
HashAggregate  (cost=338887.85..339429.51 rows=54166 width=44)
  Group Key: f.name
  ->  Gather  (cost=333065.01..338752.44 rows=54166 width=44)
        Workers Planned: 2
        ->  HashAggregate  (cost=332065.01..332335.84 rows=27083 width=44)
              Group Key: f.name
              ->  Nested Loop  (cost=0.43..331997.30 rows=27083 width=44)
                    ->  Parallel Seq Scan on seance s  (cost=0.00..176839.00 rows=27083 width=8)
                          Filter: ((date)::date = '2024-01-22'::date)
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52)
                          Index Cond: (id = s.film_id)
JIT:
  Functions: 10
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
```

EXPLAIN ANALYSE
```
HashAggregate  (cost=338887.85..339429.51 rows=54166 width=44) (actual time=1040.791..1137.639 rows=285557 loops=1)
  Group Key: f.name
  Batches: 21  Memory Usage: 8249kB  Disk Usage: 15880kB
  ->  Gather  (cost=333065.01..338752.44 rows=54166 width=44) (actual time=943.024..976.810 rows=288328 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  HashAggregate  (cost=332065.01..332335.84 rows=27083 width=44) (actual time=931.899..954.709 rows=96109 loops=3)
              Group Key: f.name
              Batches: 5  Memory Usage: 8753kB  Disk Usage: 3608kB
              Worker 0:  Batches: 5  Memory Usage: 8497kB  Disk Usage: 3560kB
              Worker 1:  Batches: 5  Memory Usage: 8497kB  Disk Usage: 3568kB
              ->  Nested Loop  (cost=0.43..331997.30 rows=27083 width=44) (actual time=5.687..885.399 rows=96547 loops=3)
                    ->  Parallel Seq Scan on seance s  (cost=0.00..176839.00 rows=27083 width=8) (actual time=5.615..376.735 rows=96547 loops=3)
                          Filter: ((date)::date = '2024-01-22'::date)
                          Rows Removed by Filter: 4236787
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=289640)
                          Index Cond: (id = s.film_id)
Planning Time: 0.214 ms
JIT:
  Functions: 49
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.354 ms, Inlining 0.000 ms, Optimization 1.517 ms, Emission 21.046 ms, Total 24.916 ms"
Execution Time: 1146.353 ms

```

Добавляем индекс:
```sql
CREATE INDEX CONCURRENTLY IF NOT EXISTS seance_date__ind ON seance (date(timezone('UTC', date)));
```

Смотрим план:
```
HashAggregate  (cost=338887.85..339429.51 rows=54166 width=44) (actual time=1099.278..1258.926 rows=285557 loops=1)
  Group Key: f.name
  Batches: 21  Memory Usage: 8249kB  Disk Usage: 19424kB
  ->  Gather  (cost=333065.01..338752.44 rows=54166 width=44) (actual time=992.604..1026.311 rows=288280 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  HashAggregate  (cost=332065.01..332335.84 rows=27083 width=44) (actual time=981.604..1005.794 rows=96093 loops=3)
              Group Key: f.name
              Batches: 5  Memory Usage: 8497kB  Disk Usage: 3560kB
              Worker 0:  Batches: 5  Memory Usage: 9009kB  Disk Usage: 3520kB
              Worker 1:  Batches: 5  Memory Usage: 8753kB  Disk Usage: 3552kB
              ->  Nested Loop  (cost=0.43..331997.30 rows=27083 width=44) (actual time=6.418..933.736 rows=96547 loops=3)
                    ->  Parallel Seq Scan on seance s  (cost=0.00..176839.00 rows=27083 width=8) (actual time=6.353..395.386 rows=96547 loops=3)
                          Filter: ((date)::date = '2024-01-22'::date)
                          Rows Removed by Filter: 4236787
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=289640)
                          Index Cond: (id = s.film_id)
Planning Time: 0.270 ms
JIT:
  Functions: 49
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.239 ms, Inlining 0.000 ms, Optimization 1.537 ms, Emission 23.588 ms, Total 27.364 ms"
Execution Time: 1268.391 ms

```

видим, что запрос не использует индекс.
Правим запрос:
```sql
SELECT DISTINCT f.name as film
FROM seance s
     JOIN public.film f
          on f.id = s.film_id
WHERE date(timezone('UTC', date)) = '2024.01.22';
```
Смотрим план:
```
HashAggregate  (cost=253616.75..254158.41 rows=54166 width=44) (actual time=993.936..1097.170 rows=285557 loops=1)
  Group Key: f.name
  Batches: 21  Memory Usage: 8249kB  Disk Usage: 15888kB
  ->  Gather  (cost=247793.91..253481.34 rows=54166 width=44) (actual time=892.517..927.782 rows=288273 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  HashAggregate  (cost=246793.91..247064.74 rows=27083 width=44) (actual time=880.852..904.208 rows=96091 loops=3)
              Group Key: f.name
              Batches: 5  Memory Usage: 8753kB  Disk Usage: 3552kB
              Worker 0:  Batches: 5  Memory Usage: 8497kB  Disk Usage: 3600kB
              Worker 1:  Batches: 5  Memory Usage: 8753kB  Disk Usage: 3520kB
              ->  Nested Loop  (cost=728.62..246726.20 rows=27083 width=44) (actual time=19.242..834.755 rows=96547 loops=3)
                    ->  Parallel Bitmap Heap Scan on seance s  (cost=728.18..91567.90 rows=27083 width=8) (actual time=15.568..305.403 rows=96547 loops=3)
"                          Recheck Cond: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
                          Rows Removed by Index Recheck: 1462773
                          Heap Blocks: exact=19484 lossy=11131
                          ->  Bitmap Index Scan on seance_date__ind  (cost=0.00..711.93 rows=65000 width=0) (actual time=17.538..17.538 rows=289640 loops=1)
"                                Index Cond: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=289640)
                          Index Cond: (id = s.film_id)
Planning Time: 0.284 ms
JIT:
  Functions: 49
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.513 ms, Inlining 0.000 ms, Optimization 1.524 ms, Emission 21.691 ms, Total 25.727 ms"
Execution Time: 1106.165 ms
```
Стоимость запроса уменьшена.
Избавляемся от агрегации:
```sql
SELECT f.name as film
FROM seance s
     JOIN public.film f
          on f.id = s.film_id
WHERE f.id IN (SELECT film_id
               FROM seance
               WHERE date(timezone('UTC', date)) = date(timezone('UTC', '2024.01.22')));
```

```
Gather  (cost=94851.07..312525.26 rows=84500 width=44) (actual time=1197.040..4093.983 rows=653114 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Nested Loop  (cost=93851.07..303075.26 rows=35208 width=44) (actual time=1185.313..4039.445 rows=217705 loops=3)
        ->  Hash Join  (cost=93850.64..264617.47 rows=70144 width=16) (actual time=1185.265..2878.742 rows=217705 loops=3)
              Hash Cond: (s.film_id = seance.film_id)
              ->  Parallel Seq Scan on seance s  (cost=0.00..149755.67 rows=5416667 width=8) (actual time=0.013..206.743 rows=4333333 loops=3)
              ->  Hash  (cost=93041.36..93041.36 rows=64742 width=8) (actual time=1184.969..1184.971 rows=285557 loops=3)
                    Buckets: 262144 (originally 65536)  Batches: 2 (originally 1)  Memory Usage: 7628kB
                    ->  HashAggregate  (cost=92393.94..93041.36 rows=64742 width=8) (actual time=1034.510..1135.717 rows=285557 loops=3)
                          Group Key: seance.film_id
                          Batches: 21  Memory Usage: 11057kB  Disk Usage: 7216kB
                          Worker 0:  Batches: 21  Memory Usage: 11057kB  Disk Usage: 7216kB
                          Worker 1:  Batches: 21  Memory Usage: 11057kB  Disk Usage: 7216kB
                          ->  Bitmap Heap Scan on seance  (cost=728.18..92231.44 rows=65000 width=8) (actual time=29.997..937.813 rows=289640 loops=3)
"                                Recheck Cond: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
                                Rows Removed by Index Recheck: 4388319
                                Heap Blocks: exact=58056 lossy=33038
                                ->  Bitmap Index Scan on seance_date__ind  (cost=0.00..711.93 rows=65000 width=0) (actual time=13.823..13.823 rows=289640 loops=3)
"                                      Index Cond: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
        ->  Index Scan using film_pkey on film f  (cost=0.43..0.55 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=653114)
              Index Cond: (id = s.film_id)
Planning Time: 0.328 ms
JIT:
  Functions: 75
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 3.324 ms, Inlining 0.000 ms, Optimization 1.827 ms, Emission 28.414 ms, Total 33.565 ms"
Execution Time: 4115.764 ms
```
Стоимость запроса стале меньше более чем в 2 раза.

Удаляем индекс seance_date__ind и смотрим план:
```
Nested Loop  (cost=199500.30..567814.57 rows=84500 width=44) (actual time=767.827..8931.715 rows=653114 loops=1)
  ->  Hash Join  (cost=199499.86..475515.64 rows=168346 width=16) (actual time=767.790..5548.629 rows=653114 loops=1)
        Hash Cond: (s.film_id = seance.film_id)
        ->  Seq Scan on seance s  (cost=0.00..225589.00 rows=13000000 width=8) (actual time=0.012..622.623 rows=13000000 loops=1)
        ->  Hash  (cost=198690.59..198690.59 rows=64742 width=8) (actual time=767.542..767.618 rows=285557 loops=1)
              Buckets: 262144 (originally 65536)  Batches: 2 (originally 1)  Memory Usage: 7628kB
              ->  HashAggregate  (cost=198043.17..198690.59 rows=64742 width=8) (actual time=624.986..721.076 rows=285557 loops=1)
                    Group Key: seance.film_id
                    Batches: 21  Memory Usage: 11057kB  Disk Usage: 7208kB
                    ->  Gather  (cost=1000.00..197880.67 rows=65000 width=8) (actual time=102.993..534.996 rows=289640 loops=1)
                          Workers Planned: 2
                          Workers Launched: 2
                          ->  Parallel Seq Scan on seance  (cost=0.00..190380.67 rows=27083 width=8) (actual time=67.529..554.563 rows=96547 loops=3)
"                                Filter: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
                                Rows Removed by Filter: 4236787
  ->  Index Scan using film_pkey on film f  (cost=0.43..0.55 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=653114)
        Index Cond: (id = s.film_id)
Planning Time: 0.288 ms
JIT:
  Functions: 33
"  Options: Inlining true, Optimization true, Expressions true, Deforming true"
"  Timing: Generation 1.492 ms, Inlining 76.298 ms, Optimization 75.029 ms, Emission 57.099 ms, Total 209.919 ms"
Execution Time: 8962.969 ms
```
Стоимость выросла в два раза, значит индекс seance_date__ind оставляем.
&nbsp;

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
Finalize Aggregate  (cost=189166.55..189166.56 rows=1 width=8)
  ->  Gather  (cost=189166.33..189166.54 rows=2 width=8)
        Workers Planned: 2
        ->  Partial Aggregate  (cost=188166.33..188166.34 rows=1 width=8)
              ->  Parallel Seq Scan on ticket t  (cost=0.00..188114.25 rows=20833 width=0)
                    Filter: (((date)::date >= CURRENT_DATE) AND ((date)::date <= (CURRENT_DATE + '7 days'::interval)))
JIT:
  Functions: 6
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"

```

EXPLAIN ANALYSE:
```
Finalize Aggregate  (cost=157916.30..157916.31 rows=1 width=8) (actual time=398.766..401.805 rows=1 loops=1)
  ->  Gather  (cost=157916.08..157916.29 rows=2 width=8) (actual time=398.674..401.795 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial Aggregate  (cost=156916.08..156916.09 rows=1 width=8) (actual time=388.304..388.305 rows=1 loops=3)
              ->  Parallel Seq Scan on ticket t  (cost=0.00..156864.00 rows=20833 width=0) (actual time=2.929..368.358 rows=703236 loops=3)
                    Filter: (((date)::date >= '2024-01-22'::date) AND ((date)::date <= '2024-01-29 00:00:00'::timestamp without time zone))
                    Rows Removed by Filter: 2630097
Planning Time: 0.050 ms
JIT:
  Functions: 14
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.945 ms, Inlining 0.000 ms, Optimization 0.504 ms, Emission 8.280 ms, Total 9.728 ms"
Execution Time: 402.121 ms
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
Aggregate  (cost=71572.18..71572.19 rows=1 width=8) (actual time=1029.916..1029.917 rows=1 loops=1)
  ->  Bitmap Heap Scan on ticket t  (cost=684.93..71447.18 rows=50000 width=0) (actual time=47.836..971.205 rows=2109708 loops=1)
"        Recheck Cond: ((date(timezone('UTC'::text, date)) >= '2024-01-22'::date) AND (date(timezone('UTC'::text, date)) <= '2024-01-29 00:00:00'::timestamp without time zone))"
        Rows Removed by Index Recheck: 3543315
        Heap Blocks: exact=40476 lossy=33054
        ->  Bitmap Index Scan on ticket_date__ind  (cost=0.00..672.43 rows=50000 width=0) (actual time=42.780..42.780 rows=2109708 loops=1)
"              Index Cond: ((date(timezone('UTC'::text, date)) >= '2024-01-22'::date) AND (date(timezone('UTC'::text, date)) <= '2024-01-29 00:00:00'::timestamp without time zone))"
Planning Time: 0.055 ms
Execution Time: 1030.008 ms
```

Стоимость запроса уменьшена более чем в два раза с использованием индекса.
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
Gather Merge  (cost=484493.34..490813.15 rows=54166 width=70)
  Workers Planned: 2
  ->  Sort  (cost=483493.32..483561.03 rows=27083 width=70)
        Sort Key: s.date
        ->  Nested Loop  (cost=0.87..481499.32 rows=27083 width=70)
              ->  Nested Loop  (cost=0.43..345539.51 rows=27083 width=60)
                    ->  Parallel Seq Scan on seance s  (cost=0.00..190379.01 rows=27083 width=24)
                          Filter: ((date)::date = CURRENT_DATE)
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52)
                          Index Cond: (id = s.film_id)
              ->  Index Scan using hall_pkey on hall h  (cost=0.43..5.02 rows=1 width=18)
                    Index Cond: (id = s.hall_id)
JIT:
  Functions: 11
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"

```

EXPLAIN ANALYSE
```
Gather Merge  (cost=470950.90..477270.71 rows=54166 width=70) (actual time=1491.923..1542.301 rows=289640 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=469950.87..470018.58 rows=27083 width=70) (actual time=1480.337..1492.697 rows=96547 loops=3)
        Sort Key: s.date
        Sort Method: external merge  Disk: 8272kB
        Worker 0:  Sort Method: external merge  Disk: 7928kB
        Worker 1:  Sort Method: external merge  Disk: 7880kB
        ->  Nested Loop  (cost=0.87..467956.88 rows=27083 width=70) (actual time=6.450..1444.690 rows=96547 loops=3)
              ->  Nested Loop  (cost=0.43..331997.30 rows=27083 width=60) (actual time=6.414..929.108 rows=96547 loops=3)
                    ->  Parallel Seq Scan on seance s  (cost=0.00..176839.00 rows=27083 width=24) (actual time=6.336..384.237 rows=96547 loops=3)
                          Filter: ((date)::date = '2024-01-22'::date)
                          Rows Removed by Filter: 4236787
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=289640)
                          Index Cond: (id = s.film_id)
              ->  Index Scan using hall_pkey on hall h  (cost=0.43..5.02 rows=1 width=18) (actual time=0.005..0.005 rows=1 loops=289640)
                    Index Cond: (id = s.hall_id)
Planning Time: 0.580 ms
JIT:
  Functions: 39
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.733 ms, Inlining 0.000 ms, Optimization 0.789 ms, Emission 18.164 ms, Total 20.686 ms"
Execution Time: 1551.347 ms
```

Указываем тайм зону для использования индекса
```sql
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

```
Gather Merge  (cost=385679.80..391999.61 rows=54166 width=70) (actual time=1370.946..1422.644 rows=289640 loops=1)
  Workers Planned: 2
  Workers Launched: 2
  ->  Sort  (cost=384679.78..384747.49 rows=27083 width=70) (actual time=1359.059..1371.451 rows=96547 loops=3)
        Sort Key: s.date
        Sort Method: external merge  Disk: 8064kB
        Worker 0:  Sort Method: external merge  Disk: 8032kB
        Worker 1:  Sort Method: external merge  Disk: 7992kB
        ->  Nested Loop  (cost=729.05..382685.78 rows=27083 width=70) (actual time=20.036..1324.277 rows=96547 loops=3)
              ->  Nested Loop  (cost=728.62..246726.20 rows=27083 width=60) (actual time=20.009..831.417 rows=96547 loops=3)
                    ->  Parallel Bitmap Heap Scan on seance s  (cost=728.18..91567.90 rows=27083 width=24) (actual time=15.277..298.589 rows=96547 loops=3)
"                          Recheck Cond: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
                          Rows Removed by Index Recheck: 1462773
                          Heap Blocks: exact=19488 lossy=11066
                          ->  Bitmap Index Scan on seance_date__ind  (cost=0.00..711.93 rows=65000 width=0) (actual time=17.460..17.461 rows=289640 loops=1)
"                                Index Cond: (date(timezone('UTC'::text, date)) = '2024-01-22'::date)"
                    ->  Index Scan using film_pkey on film f  (cost=0.43..5.73 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=289640)
                          Index Cond: (id = s.film_id)
              ->  Index Scan using hall_pkey on hall h  (cost=0.43..5.02 rows=1 width=18) (actual time=0.005..0.005 rows=1 loops=289640)
                    Index Cond: (id = s.hall_id)
Planning Time: 0.299 ms
JIT:
  Functions: 39
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 2.023 ms, Inlining 0.000 ms, Optimization 0.982 ms, Emission 18.150 ms, Total 21.156 ms"
Execution Time: 1431.619 ms

```
Стоимость запроса уменьшена.
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
Limit  (cost=353924.76..353924.77 rows=3 width=76)
  ->  Sort  (cost=353924.76..354049.76 rows=50000 width=76)
        Sort Key: (sum(p.price)) DESC
        ->  Finalize GroupAggregate  (cost=347115.07..353278.52 rows=50000 width=76)
              Group Key: f.name
              ->  Gather Merge  (cost=347115.07..352341.02 rows=41666 width=76)
                    Workers Planned: 2
                    ->  Partial GroupAggregate  (cost=346115.05..346531.71 rows=20833 width=76)
                          Group Key: f.name
                          ->  Sort  (cost=346115.05..346167.13 rows=20833 width=49)
                                Sort Key: f.name
                                ->  Nested Loop  (cost=1.30..344620.64 rows=20833 width=49)
                                      ->  Nested Loop  (cost=0.87..324589.93 rows=20833 width=13)
                                            ->  Nested Loop  (cost=0.43..303054.49 rows=20833 width=13)
                                                  ->  Parallel Seq Scan on ticket t  (cost=0.00..188114.25 rows=20833 width=8)
                                                        Filter: (((date)::date >= CURRENT_DATE) AND ((date)::date <= (CURRENT_DATE + '7 days'::interval)))
                                                  ->  Index Scan using price_pkey on price p  (cost=0.43..5.52 rows=1 width=21)
                                                        Index Cond: (id = t.price)
                                            ->  Index Scan using seance_pkey on seance s  (cost=0.43..1.03 rows=1 width=16)
                                                  Index Cond: (id = p.seance_id)
                                      ->  Index Scan using film_pkey on film f  (cost=0.43..0.96 rows=1 width=52)
                                            Index Cond: (id = s.film_id)
JIT:
  Functions: 23
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"

```

EXPLAIN ANALYSE:
```
Limit  (cost=322673.82..322673.83 rows=3 width=76) (actual time=10904.090..10913.961 rows=3 loops=1)
  ->  Sort  (cost=322673.82..322798.82 rows=50000 width=76) (actual time=10895.602..10905.473 rows=3 loops=1)
        Sort Key: (sum(p.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=315864.13..322027.58 rows=50000 width=76) (actual time=8831.553..10769.124 rows=837973 loops=1)
              Group Key: f.name
              ->  Gather Merge  (cost=315864.13..321090.08 rows=41666 width=76) (actual time=8831.537..9640.802 rows=1473709 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=314864.11..315280.77 rows=20833 width=76) (actual time=8803.224..9227.278 rows=491236 loops=3)
                          Group Key: f.name
                          ->  Sort  (cost=314864.11..314916.19 rows=20833 width=49) (actual time=8803.188..8965.684 rows=703236 loops=3)
                                Sort Key: f.name
                                Sort Method: external merge  Disk: 41608kB
                                Worker 0:  Sort Method: external merge  Disk: 41120kB
                                Worker 1:  Sort Method: external merge  Disk: 40392kB
                                ->  Nested Loop  (cost=1.30..313369.70 rows=20833 width=49) (actual time=6.111..7282.582 rows=703236 loops=3)
                                      ->  Nested Loop  (cost=0.87..293339.01 rows=20833 width=13) (actual time=6.081..3624.756 rows=703236 loops=3)
                                            ->  Nested Loop  (cost=0.43..271803.58 rows=20833 width=13) (actual time=6.049..1400.037 rows=703236 loops=3)
                                                  ->  Parallel Seq Scan on ticket t  (cost=0.00..156863.33 rows=20833 width=8) (actual time=5.994..426.580 rows=703236 loops=3)
                                                        Filter: (((date)::date >= '2024-01-22'::date) AND ((date)::date <= '2024-01-29 00:00:00'::timestamp without time zone))
                                                        Rows Removed by Filter: 2630097
                                                  ->  Index Scan using price_pkey on price p  (cost=0.43..5.52 rows=1 width=21) (actual time=0.001..0.001 rows=1 loops=2109708)
                                                        Index Cond: (id = t.price)
                                            ->  Index Scan using seance_pkey on seance s  (cost=0.43..1.03 rows=1 width=16) (actual time=0.003..0.003 rows=1 loops=2109708)
                                                  Index Cond: (id = p.seance_id)
                                      ->  Index Scan using film_pkey on film f  (cost=0.43..0.96 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=2109708)
                                            Index Cond: (id = s.film_id)
Planning Time: 0.443 ms
JIT:
  Functions: 70
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 3.508 ms, Inlining 0.000 ms, Optimization 1.117 ms, Emission 25.371 ms, Total 29.996 ms"
Execution Time: 10920.615 ms
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

```
Limit  (cost=236528.50..236528.51 rows=3 width=76) (actual time=10940.850..10950.654 rows=3 loops=1)
  ->  Sort  (cost=236528.50..236653.50 rows=50000 width=76) (actual time=10932.572..10942.375 rows=3 loops=1)
        Sort Key: (sum(p.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=229718.81..235882.26 rows=50000 width=76) (actual time=8884.334..10806.646 rows=837973 loops=1)
              Group Key: f.name
              ->  Gather Merge  (cost=229718.81..234944.76 rows=41666 width=76) (actual time=8884.319..9687.823 rows=1473559 loops=1)
                    Workers Planned: 2
                    Workers Launched: 2
                    ->  Partial GroupAggregate  (cost=228718.79..229135.45 rows=20833 width=76) (actual time=8860.972..9282.381 rows=491186 loops=3)
                          Group Key: f.name
                          ->  Sort  (cost=228718.79..228770.87 rows=20833 width=49) (actual time=8860.939..9022.926 rows=703236 loops=3)
                                Sort Key: f.name
                                Sort Method: external merge  Disk: 41440kB
                                Worker 0:  Sort Method: external merge  Disk: 40760kB
                                Worker 1:  Sort Method: external merge  Disk: 40920kB
                                ->  Nested Loop  (cost=686.24..227224.38 rows=20833 width=49) (actual time=47.403..7335.592 rows=703236 loops=3)
                                      ->  Nested Loop  (cost=685.80..207193.69 rows=20833 width=13) (actual time=47.372..3677.452 rows=703236 loops=3)
                                            ->  Nested Loop  (cost=685.37..185658.26 rows=20833 width=13) (actual time=47.347..1448.508 rows=703236 loops=3)
                                                  ->  Parallel Bitmap Heap Scan on ticket t  (cost=684.93..70718.01 rows=20833 width=8) (actual time=41.192..434.083 rows=703236 loops=3)
"                                                        Recheck Cond: ((date(timezone('UTC'::text, date)) >= '2024-01-22'::date) AND (date(timezone('UTC'::text, date)) <= '2024-01-29 00:00:00'::timestamp without time zone))"
                                                        Rows Removed by Index Recheck: 1181105
                                                        Heap Blocks: exact=13706 lossy=11037
                                                        ->  Bitmap Index Scan on ticket_date__ind  (cost=0.00..672.43 rows=50000 width=0) (actual time=47.431..47.431 rows=2109708 loops=1)
"                                                              Index Cond: ((date(timezone('UTC'::text, date)) >= '2024-01-22'::date) AND (date(timezone('UTC'::text, date)) <= '2024-01-29 00:00:00'::timestamp without time zone))"
                                                  ->  Index Scan using price_pkey on price p  (cost=0.43..5.52 rows=1 width=21) (actual time=0.001..0.001 rows=1 loops=2109708)
                                                        Index Cond: (id = t.price)
                                            ->  Index Scan using seance_pkey on seance s  (cost=0.43..1.03 rows=1 width=16) (actual time=0.003..0.003 rows=1 loops=2109708)
                                                  Index Cond: (id = p.seance_id)
                                      ->  Index Scan using film_pkey on film f  (cost=0.43..0.96 rows=1 width=52) (actual time=0.005..0.005 rows=1 loops=2109708)
                                            Index Cond: (id = s.film_id)
Planning Time: 0.569 ms
JIT:
  Functions: 70
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 3.152 ms, Inlining 0.000 ms, Optimization 1.177 ms, Emission 25.502 ms, Total 29.831 ms"
Execution Time: 10956.582 ms
```
Стоимсоть запроса уменьшена.
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
Sort  (cost=326485.56..326485.58 rows=10 width=46)
"  Sort Key: pl.""row"", pl.number"
  ->  Nested Loop  (cost=126615.74..326485.39 rows=10 width=46)
        ->  Nested Loop  (cost=126615.31..326480.42 rows=10 width=20)
              ->  Hash Right Join  (cost=126614.88..326395.90 rows=10 width=16)
                    Hash Cond: (t.price = pr.id)
                    ->  Seq Scan on ticket t  (cost=0.00..173530.80 rows=10000080 width=16)
                    ->  Hash  (cost=126614.75..126614.75 rows=10 width=16)
                          ->  Gather  (cost=1000.00..126614.75 rows=10 width=16)
                                Workers Planned: 2
                                ->  Parallel Seq Scan on price pr  (cost=0.00..125613.75 rows=4 width=16)
                                      Filter: (seance_id = 1000)
              ->  Index Scan using place_pkey on place pl  (cost=0.43..8.45 rows=1 width=20)
                    Index Cond: (id = pr.place_id)
        ->  Index Scan using hall_pkey on hall h  (cost=0.43..0.50 rows=1 width=18)
              Index Cond: (id = pl.hall_id)
JIT:
  Functions: 21
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"

```

EXPLAIN ANALYSE:
```
Sort  (cost=326484.55..326484.57 rows=10 width=46) (actual time=1037.374..1037.448 rows=12 loops=1)
"  Sort Key: pl.""row"", pl.number"
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=126615.74..326484.38 rows=10 width=46) (actual time=134.478..1037.411 rows=12 loops=1)
        ->  Nested Loop  (cost=126615.31..326479.41 rows=10 width=20) (actual time=134.463..1037.328 rows=12 loops=1)
              ->  Hash Right Join  (cost=126614.88..326394.89 rows=10 width=16) (actual time=134.433..1037.178 rows=12 loops=1)
                    Hash Cond: (t.price = pr.id)
                    ->  Seq Scan on ticket t  (cost=0.00..173530.00 rows=10000000 width=16) (actual time=0.010..459.616 rows=10000000 loops=1)
                    ->  Hash  (cost=126614.75..126614.75 rows=10 width=16) (actual time=133.513..133.584 rows=12 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Gather  (cost=1000.00..126614.75 rows=10 width=16) (actual time=8.401..133.563 rows=12 loops=1)
                                Workers Planned: 2
                                Workers Launched: 2
                                ->  Parallel Seq Scan on price pr  (cost=0.00..125613.75 rows=4 width=16) (actual time=20.520..123.409 rows=4 loops=3)
                                      Filter: (seance_id = 1000)
                                      Rows Removed by Filter: 3333329
              ->  Index Scan using place_pkey on place pl  (cost=0.43..8.45 rows=1 width=20) (actual time=0.008..0.008 rows=1 loops=12)
                    Index Cond: (id = pr.place_id)
        ->  Index Scan using hall_pkey on hall h  (cost=0.43..0.50 rows=1 width=18) (actual time=0.004..0.004 rows=1 loops=12)
              Index Cond: (id = pl.hall_id)
Planning Time: 0.467 ms
JIT:
  Functions: 31
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.233 ms, Inlining 0.000 ms, Optimization 0.741 ms, Emission 13.655 ms, Total 15.629 ms"
Execution Time: 1038.325 ms

```

Добавляем индекс place_row_number__ind:
```sql
CREATE INDEX CONCURRENTLY IF NOT EXISTS place_row_number__ind ON place(row, number);
```

```
Sort  (cost=326484.55..326484.57 rows=10 width=46) (actual time=1003.027..1003.103 rows=12 loops=1)
"  Sort Key: pl.""row"", pl.number"
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=126615.74..326484.38 rows=10 width=46) (actual time=134.456..1003.064 rows=12 loops=1)
        ->  Nested Loop  (cost=126615.31..326479.41 rows=10 width=20) (actual time=134.426..1002.965 rows=12 loops=1)
              ->  Hash Right Join  (cost=126614.88..326394.89 rows=10 width=16) (actual time=134.381..1002.749 rows=12 loops=1)
                    Hash Cond: (t.price = pr.id)
                    ->  Seq Scan on ticket t  (cost=0.00..173530.00 rows=10000000 width=16) (actual time=0.009..429.019 rows=10000000 loops=1)
                    ->  Hash  (cost=126614.75..126614.75 rows=10 width=16) (actual time=133.475..133.548 rows=12 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Gather  (cost=1000.00..126614.75 rows=10 width=16) (actual time=8.607..133.531 rows=12 loops=1)
                                Workers Planned: 2
                                Workers Launched: 2
                                ->  Parallel Seq Scan on price pr  (cost=0.00..125613.75 rows=4 width=16) (actual time=12.066..123.514 rows=4 loops=3)
                                      Filter: (seance_id = 1000)
                                      Rows Removed by Filter: 3333329
              ->  Index Scan using place_pkey on place pl  (cost=0.43..8.45 rows=1 width=20) (actual time=0.013..0.013 rows=1 loops=12)
                    Index Cond: (id = pr.place_id)
        ->  Index Scan using hall_pkey on hall h  (cost=0.43..0.50 rows=1 width=18) (actual time=0.006..0.006 rows=1 loops=12)
              Index Cond: (id = pl.hall_id)
Planning Time: 0.445 ms
JIT:
  Functions: 31
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.181 ms, Inlining 0.000 ms, Optimization 0.686 ms, Emission 13.235 ms, Total 15.102 ms"
Execution Time: 1003.871 ms
```
Стоимость запроса не изменилась. Удаляем индекс place_row_number__ind.


После добавления индекса в пункте 6:
```
Sort  (cost=199914.40..199914.43 rows=10 width=46) (actual time=893.964..893.967 rows=12 loops=1)
"  Sort Key: pl.""row"", pl.number"
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=45.60..199914.24 rows=10 width=46) (actual time=8.648..893.923 rows=12 loops=1)
        ->  Nested Loop  (cost=45.17..199909.27 rows=10 width=20) (actual time=8.637..893.842 rows=12 loops=1)
              ->  Hash Right Join  (cost=44.73..199824.75 rows=10 width=16) (actual time=8.621..893.696 rows=12 loops=1)
                    Hash Cond: (t.price = pr.id)
                    ->  Seq Scan on ticket t  (cost=0.00..173530.00 rows=10000000 width=16) (actual time=0.020..436.400 rows=10000000 loops=1)
                    ->  Hash  (cost=44.61..44.61 rows=10 width=16) (actual time=7.704..7.705 rows=12 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB
                          ->  Index Scan using price_seance_id__ind on price pr  (cost=0.43..44.61 rows=10 width=16) (actual time=7.683..7.694 rows=12 loops=1)
                                Index Cond: (seance_id = 1000)
              ->  Index Scan using place_pkey on place pl  (cost=0.43..8.45 rows=1 width=20) (actual time=0.008..0.008 rows=1 loops=12)
                    Index Cond: (id = pr.place_id)
        ->  Index Scan using hall_pkey on hall h  (cost=0.43..0.50 rows=1 width=18) (actual time=0.004..0.004 rows=1 loops=12)
              Index Cond: (id = pl.hall_id)
Planning Time: 0.472 ms
JIT:
  Functions: 23
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 0.731 ms, Inlining 0.000 ms, Optimization 0.340 ms, Emission 7.335 ms, Total 8.406 ms"
Execution Time: 894.807 ms
```
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
Finalize GroupAggregate  (cost=1000.00..126614.93 rows=10 width=40)
  Group Key: seance_id
  ->  Gather  (cost=1000.00..126614.62 rows=8 width=72)
        Workers Planned: 2
        ->  Partial GroupAggregate  (cost=0.00..125613.82 rows=4 width=72)
              Group Key: seance_id
              ->  Parallel Seq Scan on price pr  (cost=0.00..125613.75 rows=4 width=13)
                    Filter: (seance_id = 1000)
JIT:
  Functions: 10
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"

```

EXPLAIN ANALYSE:
```
Finalize GroupAggregate  (cost=1000.00..126614.93 rows=10 width=40) (actual time=143.126..146.008 rows=1 loops=1)
  Group Key: seance_id
  ->  Gather  (cost=1000.00..126614.62 rows=8 width=72) (actual time=142.974..145.988 rows=3 loops=1)
        Workers Planned: 2
        Workers Launched: 2
        ->  Partial GroupAggregate  (cost=0.00..125613.82 rows=4 width=72) (actual time=132.414..132.415 rows=1 loops=3)
              Group Key: seance_id
              ->  Parallel Seq Scan on price pr  (cost=0.00..125613.75 rows=4 width=13) (actual time=31.129..132.351 rows=4 loops=3)
                    Filter: (seance_id = 1000)
                    Rows Removed by Filter: 3333329
Planning Time: 0.154 ms
JIT:
  Functions: 24
"  Options: Inlining false, Optimization false, Expressions true, Deforming true"
"  Timing: Generation 1.409 ms, Inlining 0.000 ms, Optimization 0.849 ms, Emission 16.468 ms, Total 18.727 ms"
Execution Time: 146.559 ms
```

Добавляем индекс price_seance_id__ind:
```
CREATE INDEX CONCURRENTLY IF NOT EXISTS price_seance_id__ind ON price(seance_id);
```

```
GroupAggregate  (cost=0.43..44.93 rows=10 width=40) (actual time=0.049..0.049 rows=1 loops=1)
  Group Key: seance_id
  ->  Index Scan using price_seance_id__ind on price pr  (cost=0.43..44.61 rows=10 width=13) (actual time=0.032..0.040 rows=12 loops=1)
        Index Cond: (seance_id = 1000)
Planning Time: 0.087 ms
Execution Time: 0.106 ms
```
Стоимость запроса уменьшена в десятки раз!
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
public.client,5007 MB,2276 MB
public.film,2432 MB,2217 MB
public.client_email_key,1989 MB,1989 MB
public.seance,1026 MB,747 MB
public.hall,865 MB,651 MB
public.price,789 MB,574 MB
public.place,789 MB,574 MB
public.ticket,789 MB,574 MB
public.client_phone_key,527 MB,527 MB
public.seance_pkey,278 MB,278 MB
public.client_pkey,214 MB,214 MB
public.ticket_pkey,214 MB,214 MB
public.place_pkey,214 MB,214 MB
public.film_pkey,214 MB,214 MB
public.hall_pkey,214 MB,214 MB
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
16617,16622,public,hall,hall_pkey,23000021,23001017,23001000
16610,16615,public,film,film_pkey,13002805,13002805,13002779
16645,16648,public,seance,seance_pkey,10002093,10002092,10002080
16624,16627,public,place,place_pkey,10000035,10000035,10000003
16660,16663,public,price,price_pkey,10000034,10000034,10000000
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
16675,16678,public,ticket,ticket_pkey,0,0,0
16634,16641,public,client,client_email_key,0,0,0
16634,16643,public,client,client_phone_key,0,0,0
16634,16639,public,client,client_pkey,10000000,10000000,10000000
16660,16663,public,price,price_pkey,10000034,10000034,10000000
```
