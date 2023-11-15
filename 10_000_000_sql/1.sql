--Выбор фильмов на сегодня
EXPLAIN ANALYSE
SELECT DISTINCT films.name
FROM
    sessions LEFT JOIN films ON films.id = sessions.film_id
WHERE
    sessions.datetime BETWEEN current_date AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;

-- HashAggregate  (cost=7057.81..7073.04 rows=1523 width=27) (actual time=59.868..60.002 rows=1605 loops=1)
--   Group Key: films.name
--   Batches: 1  Memory Usage: 193kB
--   ->  Hash Left Join  (cost=3663.00..7054.00 rows=1523 width=27) (actual time=21.646..59.410 rows=1617 loops=1)
--         Hash Cond: (sessions.film_id = films.id)
--         ->  Seq Scan on sessions  (cost=0.00..3387.00 rows=1523 width=4) (actual time=0.029..37.084 rows=1617 loops=1)
-- "              Filter: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--               Rows Removed by Filter: 98383
--         ->  Hash  (cost=2413.00..2413.00 rows=100000 width=31) (actual time=21.559..21.560 rows=100000 loops=1)
--               Buckets: 131072  Batches: 1  Memory Usage: 7397kB
--               ->  Seq Scan on films  (cost=0.00..2413.00 rows=100000 width=31) (actual time=0.060..8.391 rows=100000 loops=1)
-- Planning Time: 0.176 ms
-- Execution Time: 60.093 ms

create index idx_datetime on sessions(datetime);

-- HashAggregate  (cost=4385.60..4400.83 rows=1523 width=27) (actual time=22.983..23.097 rows=1605 loops=1)
--   Group Key: films.name
--   Batches: 1  Memory Usage: 193kB
--   ->  Hash Left Join  (cost=3698.92..4381.80 rows=1523 width=27) (actual time=21.535..22.637 rows=1617 loops=1)
--         Hash Cond: (sessions.film_id = films.id)
--         ->  Bitmap Heap Scan on sessions  (cost=35.92..714.80 rows=1523 width=4) (actual time=0.159..0.728 rows=1617 loops=1)
-- "              Recheck Cond: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--               Heap Blocks: exact=590
--               ->  Bitmap Index Scan on idx_datetime  (cost=0.00..35.53 rows=1523 width=0) (actual time=0.104..0.104 rows=1617 loops=1)
-- "                    Index Cond: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--         ->  Hash  (cost=2413.00..2413.00 rows=100000 width=31) (actual time=21.314..21.314 rows=100000 loops=1)
--               Buckets: 131072  Batches: 1  Memory Usage: 7397kB
--               ->  Seq Scan on films  (cost=0.00..2413.00 rows=100000 width=31) (actual time=0.058..8.367 rows=100000 loops=1)
-- Planning Time: 0.160 ms
-- Execution Time: 23.187 ms

--Анализ: Создание индекса по полю datetime ускорило выполнение запроса более чем в 2 раза
--Вывод: Создание индекса оправдано и полезно