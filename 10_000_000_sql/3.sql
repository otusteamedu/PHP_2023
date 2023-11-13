--Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYSE
SELECT
    f.name as "Film name",
    s.datetime as "Datetime",
    h.name as "Hall name",
    p.price as "Price"
FROM sessions as s
         LEFT JOIN films f ON s.film_id = f.id
         LEFT JOIN halls h ON s.hall_id = h.id
         LEFT JOIN prices p ON p.session_id = s.id
WHERE s.datetime BETWEEN (concat(CURRENT_DATE, ' 00:00:00'))::timestamp AND (concat(CURRENT_DATE, ' 23:59:59'))::timestamp;

-- Hash Left Join  (cost=7858.90..8059.03 rows=1878 width=75) (actual time=96.548..98.805 rows=1752 loops=1)
--   Hash Cond: (s.hall_id = h.id)
--   ->  Hash Left Join  (cost=7823.48..8018.65 rows=1878 width=47) (actual time=96.527..98.551 rows=1752 loops=1)
--         Hash Cond: (s.film_id = f.id)
--         ->  Hash Right Join  (cost=4160.48..4350.73 rows=1878 width=24) (actual time=74.732..76.130 rows=1752 loops=1)
--               Hash Cond: (p.session_id = s.id)
--               ->  Seq Scan on prices p  (cost=0.00..164.00 rows=10000 width=12) (actual time=0.010..0.464 rows=10000 loops=1)
--               ->  Hash  (cost=4137.00..4137.00 rows=1878 width=20) (actual time=74.705..74.706 rows=1740 loops=1)
--                     Buckets: 2048  Batches: 1  Memory Usage: 105kB
--                     ->  Seq Scan on sessions s  (cost=0.00..4137.00 rows=1878 width=20) (actual time=0.053..74.375 rows=1740 loops=1)
-- "                          Filter: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                           Rows Removed by Filter: 98260
--         ->  Hash  (cost=2413.00..2413.00 rows=100000 width=31) (actual time=21.753..21.754 rows=100000 loops=1)
--               Buckets: 131072  Batches: 1  Memory Usage: 7397kB
--               ->  Seq Scan on films f  (cost=0.00..2413.00 rows=100000 width=31) (actual time=0.061..8.245 rows=100000 loops=1)
--   ->  Hash  (cost=21.30..21.30 rows=1130 width=36) (actual time=0.012..0.012 rows=10 loops=1)
--         Buckets: 2048  Batches: 1  Memory Usage: 17kB
--         ->  Seq Scan on halls h  (cost=0.00..21.30 rows=1130 width=36) (actual time=0.009..0.009 rows=10 loops=1)
-- Planning Time: 0.228 ms
-- Execution Time: 98.885 ms


create index idx_sessions_datetime on sessions(datetime);

-- Hash Left Join  (cost=4468.19..4668.32 rows=1878 width=75) (actual time=23.792..26.004 rows=1752 loops=1)
--   Hash Cond: (s.hall_id = h.id)
--   ->  Hash Left Join  (cost=4432.77..4627.95 rows=1878 width=47) (actual time=23.769..25.750 rows=1752 loops=1)
--         Hash Cond: (s.film_id = f.id)
--         ->  Hash Right Join  (cost=769.77..960.02 rows=1878 width=24) (actual time=1.111..2.496 rows=1752 loops=1)
--               Hash Cond: (p.session_id = s.id)
--               ->  Seq Scan on prices p  (cost=0.00..164.00 rows=10000 width=12) (actual time=0.005..0.480 rows=10000 loops=1)
--               ->  Hash  (cost=746.29..746.29 rows=1878 width=20) (actual time=1.093..1.095 rows=1740 loops=1)
--                     Buckets: 2048  Batches: 1  Memory Usage: 105kB
--                     ->  Bitmap Heap Scan on sessions s  (cost=43.56..746.29 rows=1878 width=20) (actual time=0.160..0.883 rows=1740 loops=1)
-- "                          Recheck Cond: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                           Heap Blocks: exact=604
--                           ->  Bitmap Index Scan on idx_sessions_datetime  (cost=0.00..43.09 rows=1878 width=0) (actual time=0.104..0.104 rows=1740 loops=1)
-- "                                Index Cond: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--         ->  Hash  (cost=2413.00..2413.00 rows=100000 width=31) (actual time=22.618..22.619 rows=100000 loops=1)
--               Buckets: 131072  Batches: 1  Memory Usage: 7397kB
--               ->  Seq Scan on films f  (cost=0.00..2413.00 rows=100000 width=31) (actual time=0.061..8.280 rows=100000 loops=1)
--   ->  Hash  (cost=21.30..21.30 rows=1130 width=36) (actual time=0.013..0.014 rows=10 loops=1)
--         Buckets: 2048  Batches: 1  Memory Usage: 17kB
--         ->  Seq Scan on halls h  (cost=0.00..21.30 rows=1130 width=36) (actual time=0.010..0.011 rows=10 loops=1)
-- Planning Time: 0.279 ms
-- Execution Time: 26.088 ms

--Анализ: Создание индекса для поля datetime ускорило выполнение запроса почти в 4 раза
-- Вывод: Создание индекса оправдано и полезно