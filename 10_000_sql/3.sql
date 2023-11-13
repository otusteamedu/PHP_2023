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

-- Nested Loop Left Join  (cost=42.65..386.76 rows=150 width=75) (actual time=0.805..2.062 rows=172 loops=1)
--   ->  Nested Loop Left Join  (cost=42.48..355.26 rows=150 width=47) (actual time=0.801..1.991 rows=172 loops=1)
--         ->  Hash Right Join  (cost=42.19..232.22 rows=150 width=24) (actual time=0.792..1.870 rows=172 loops=1)
--               Hash Cond: (p.session_id = s.id)
--               ->  Seq Scan on prices p  (cost=0.00..163.74 rows=9974 width=12) (actual time=0.004..0.455 rows=9974 loops=1)
--               ->  Hash  (cost=42.00..42.00 rows=15 width=20) (actual time=0.785..0.785 rows=16 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on sessions s  (cost=0.00..42.00 rows=15 width=20) (actual time=0.045..0.780 rows=16 loops=1)
-- "                          Filter: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                           Rows Removed by Filter: 984
--         ->  Memoize  (cost=0.30..7.51 rows=1 width=31) (actual time=0.001..0.001 rows=1 loops=172)
--               Cache Key: s.film_id
--               Cache Mode: logical
--               Hits: 156  Misses: 16  Evictions: 0  Overflows: 0  Memory Usage: 3kB
--               ->  Index Scan using films_pk on films f  (cost=0.29..7.50 rows=1 width=31) (actual time=0.003..0.003 rows=1 loops=16)
--                     Index Cond: (id = s.film_id)
--   ->  Memoize  (cost=0.16..3.11 rows=1 width=36) (actual time=0.000..0.000 rows=1 loops=172)
--         Cache Key: s.hall_id
--         Cache Mode: logical
--         Hits: 164  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--         ->  Index Scan using halls_pk on halls h  (cost=0.15..3.10 rows=1 width=36) (actual time=0.001..0.001 rows=1 loops=8)
--               Index Cond: (id = s.hall_id)
-- Planning Time: 0.266 ms
-- Execution Time: 2.099 ms


 create index idx_sessions_datetime on sessions(datetime);

-- Nested Loop Left Join  (cost=12.62..356.74 rows=150 width=75) (actual time=0.043..1.276 rows=172 loops=1)
--   ->  Nested Loop Left Join  (cost=12.46..325.23 rows=150 width=47) (actual time=0.039..1.214 rows=172 loops=1)
--         ->  Hash Right Join  (cost=12.16..202.19 rows=150 width=24) (actual time=0.032..1.116 rows=172 loops=1)
--               Hash Cond: (p.session_id = s.id)
--               ->  Seq Scan on prices p  (cost=0.00..163.74 rows=9974 width=12) (actual time=0.003..0.474 rows=9974 loops=1)
--               ->  Hash  (cost=11.97..11.97 rows=15 width=20) (actual time=0.025..0.026 rows=16 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Bitmap Heap Scan on sessions s  (cost=4.45..11.97 rows=15 width=20) (actual time=0.015..0.022 rows=16 loops=1)
-- "                          Recheck Cond: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                           Heap Blocks: exact=7
--                           ->  Bitmap Index Scan on idx_sessions_datetime  (cost=0.00..4.45 rows=15 width=0) (actual time=0.011..0.011 rows=16 loops=1)
-- "                                Index Cond: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--         ->  Memoize  (cost=0.30..7.51 rows=1 width=31) (actual time=0.000..0.000 rows=1 loops=172)
--               Cache Key: s.film_id
--               Cache Mode: logical
--               Hits: 156  Misses: 16  Evictions: 0  Overflows: 0  Memory Usage: 3kB
--               ->  Index Scan using films_pk on films f  (cost=0.29..7.50 rows=1 width=31) (actual time=0.002..0.002 rows=1 loops=16)
--                     Index Cond: (id = s.film_id)
--   ->  Memoize  (cost=0.16..3.11 rows=1 width=36) (actual time=0.000..0.000 rows=1 loops=172)
--         Cache Key: s.hall_id
--         Cache Mode: logical
--         Hits: 164  Misses: 8  Evictions: 0  Overflows: 0  Memory Usage: 1kB
--         ->  Index Scan using halls_pk on halls h  (cost=0.15..3.10 rows=1 width=36) (actual time=0.001..0.001 rows=1 loops=8)
--               Index Cond: (id = s.hall_id)
-- Planning Time: 0.280 ms
-- Execution Time: 1.309 ms

-- Анализ показал, что добавление индекса на поле session.datetime ускорило выполнение запроса почти в 2 раза
-- Вывод: добавление индекса на поле session.datetime оправдано
