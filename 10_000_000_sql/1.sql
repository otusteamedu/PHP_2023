--Выбор фильмов на сегодня
EXPLAIN ANALYSE
SELECT DISTINCT films.name
FROM
    sessions LEFT JOIN films ON films.id = sessions.film_id
WHERE
    sessions.datetime BETWEEN current_date::timestamp AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;

-- HashAggregate  (cost=7309.62..7328.40 rows=1878 width=27) (actual time=60.194..60.343 rows=1726 loops=1)
--   Group Key: films.name
--   Batches: 1  Memory Usage: 241kB
--   ->  Hash Left Join  (cost=3663.00..7304.93 rows=1878 width=27) (actual time=22.614..59.731 rows=1740 loops=1)
--         Hash Cond: (sessions.film_id = films.id)
--         ->  Seq Scan on sessions  (cost=0.00..3637.00 rows=1878 width=4) (actual time=0.040..36.582 rows=1740 loops=1)
-- "              Filter: ((datetime >= (CURRENT_DATE)::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--               Rows Removed by Filter: 98260
--         ->  Hash  (cost=2413.00..2413.00 rows=100000 width=31) (actual time=22.538..22.538 rows=100000 loops=1)
--               Buckets: 131072  Batches: 1  Memory Usage: 7397kB
--               ->  Seq Scan on films  (cost=0.00..2413.00 rows=100000 width=31) (actual time=0.053..8.525 rows=100000 loops=1)
-- Planning Time: 0.160 ms
-- Execution Time: 60.633 ms


create index idx_datetime on sessions(datetime);

-- HashAggregate  (cost=4409.52..4428.30 rows=1878 width=27) (actual time=23.150..23.306 rows=1726 loops=1)
--   Group Key: films.name
--   Batches: 1  Memory Usage: 241kB
--   ->  Hash Left Join  (cost=3706.56..4404.83 rows=1878 width=27) (actual time=21.759..22.813 rows=1740 loops=1)
--         Hash Cond: (sessions.film_id = films.id)
--         ->  Bitmap Heap Scan on sessions  (cost=43.56..736.90 rows=1878 width=4) (actual time=0.160..0.756 rows=1740 loops=1)
-- "              Recheck Cond: ((datetime >= (CURRENT_DATE)::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--               Heap Blocks: exact=604
--               ->  Bitmap Index Scan on idx_datetime  (cost=0.00..43.09 rows=1878 width=0) (actual time=0.105..0.105 rows=1740 loops=1)
-- "                    Index Cond: ((datetime >= (CURRENT_DATE)::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--         ->  Hash  (cost=2413.00..2413.00 rows=100000 width=31) (actual time=21.562..21.562 rows=100000 loops=1)
--               Buckets: 131072  Batches: 1  Memory Usage: 7397kB
--               ->  Seq Scan on films  (cost=0.00..2413.00 rows=100000 width=31) (actual time=0.054..8.473 rows=100000 loops=1)
-- Planning Time: 0.152 ms
-- Execution Time: 23.386 ms

--Анализ: Создание индекса по полю datetime ускорило выполнение запроса более чем в 2 раза
--Вывод: Создание индекса оправдано и полезно