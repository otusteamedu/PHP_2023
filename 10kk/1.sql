--Выбор фильмов на сегодня
EXPLAIN ANALYSE
SELECT DISTINCT movies.name
FROM showtime
         LEFT JOIN movies ON movies.id = showtime.movie_id
WHERE showtime.start_time BETWEEN current_date AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;

-- Unique  (cost=108.14..108.18 rows=7 width=27) (actual time=1.205..1.213 rows=9 loops=1)
--   ->  Sort  (cost=108.14..108.16 rows=7 width=27) (actual time=1.204..1.206 rows=20 loops=1)
--         Sort Key: movies.name
--         Sort Method: quicksort  Memory: 26kB
--         ->  Nested Loop Left Join  (cost=0.29..108.05 rows=7 width=27) (actual time=0.115..1.042 rows=20 loops=1)
--               ->  Seq Scan on showtime  (cost=0.00..49.88 rows=7 width=4) (actual time=0.041..0.909 rows=20 loops=1)
-- "                    Filter: ((start_time >= CURRENT_DATE) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                     Rows Removed by Filter: 980
--               ->  Index Scan using movies_pkey on movies  (cost=0.29..8.31 rows=1 width=31) (actual time=0.006..0.006 rows=1 loops=20)
--                     Index Cond: (id = showtime.movie_id)
-- Planning Time: 10.971 ms
-- Execution Time: 2.136 ms

create index idx_datetime on showtime (start_time);

-- Unique  (cost=53.60..53.62 rows=5 width=27) (actual time=0.777..0.786 rows=9 loops=1)
--   ->  Sort  (cost=53.60..53.61 rows=5 width=27) (actual time=0.776..0.778 rows=20 loops=1)
--         Sort Key: movies.name
--         Sort Method: quicksort  Memory: 26kB
--         ->  Nested Loop Left Join  (cost=4.63..53.54 rows=5 width=27) (actual time=0.584..0.689 rows=20 loops=1)
--               ->  Bitmap Heap Scan on showtime  (cost=4.34..11.99 rows=5 width=4) (actual time=0.534..0.552 rows=20 loops=1)
-- "                    Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                     Heap Blocks: exact=7
--                     ->  Bitmap Index Scan on idx_datetime  (cost=0.00..4.34 rows=5 width=0) (actual time=0.525..0.525 rows=20 loops=1)
-- "                          Index Cond: ((start_time >= CURRENT_DATE) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--               ->  Index Scan using movies_pkey on movies  (cost=0.29..8.31 rows=1 width=31) (actual time=0.004..0.004 rows=1 loops=20)
--                     Index Cond: (id = showtime.movie_id)
-- Planning Time: 2.063 ms
-- Execution Time: 0.961 ms
