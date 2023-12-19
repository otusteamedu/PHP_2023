--Выбор фильмов на сегодня
EXPLAIN
ANALYSE
SELECT DISTINCT movies.name
FROM showtime
         LEFT JOIN movies ON movies.id = showtime.movie_id
WHERE showtime.start_time BETWEEN current_date AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;
-- Unique  (cost=108.05..108.09 rows=7 width=516) (actual time=0.096..0.097 rows=1 loops=1)
--   ->  Sort  (cost=108.05..108.07 rows=7 width=516) (actual time=0.096..0.096 rows=1 loops=1)
--         Sort Key: movies.name
--         Sort Method: quicksort  Memory: 25kB
--         ->  Nested Loop Left Join  (cost=0.28..107.95 rows=7 width=516) (actual time=0.054..0.061 rows=1 loops=1)
--               ->  Seq Scan on showtime  (cost=0.00..49.88 rows=7 width=4) (actual time=0.040..0.046 rows=1 loops=1)
-- "                    Filter: ((start_time >= CURRENT_DATE) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                     Rows Removed by Filter: 99
--               ->  Index Scan using movies_pkey on movies  (cost=0.28..8.29 rows=1 width=520) (actual time=0.012..0.013 rows=1 loops=1)
--                     Index Cond: (id = showtime.movie_id)
-- Planning Time: 2.946 ms
-- Execution Time: 0.132 ms

create index idx_datetime on showtime (start_time);
-- Unique  (cost=12.07..12.08 rows=1 width=516) (actual time=0.080..0.082 rows=1 loops=1)
--   ->  Sort  (cost=12.07..12.07 rows=1 width=516) (actual time=0.080..0.080 rows=1 loops=1)
--         Sort Key: movies.name
--         Sort Method: quicksort  Memory: 25kB
--         ->  Nested Loop Left Join  (cost=0.28..12.06 rows=1 width=516) (actual time=0.054..0.062 rows=1 loops=1)
--               ->  Seq Scan on showtime  (cost=0.00..3.75 rows=1 width=4) (actual time=0.032..0.040 rows=1 loops=1)
-- "                    Filter: ((start_time >= CURRENT_DATE) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                     Rows Removed by Filter: 99
--               ->  Index Scan using movies_pkey on movies  (cost=0.28..8.29 rows=1 width=520) (actual time=0.018..0.018 rows=1 loops=1)
--                     Index Cond: (id = showtime.movie_id)
-- Planning Time: 1.595 ms
-- Execution Time: 0.134 ms