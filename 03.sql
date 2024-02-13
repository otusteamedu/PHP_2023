-- Формирование афиши (фильмы, которые показывают сегодня)
DROP INDEX start_date_index;

EXPLAIN ANALYZE SELECT
	h.name AS "Зал",
	m.title AS "Название фильма",
	s.start_time AS "Время начала"
FROM
	seances s
INNER JOIN halls h 
ON
	s.hall_id = h.hall_id
INNER JOIN movies m 
ON
	s.movie_id = m.movie_id
WHERE
	start_time = CURRENT_DATE;
	

--QUERY PLAN                                                                                                                      |
--------------------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=503.88..789.56 rows=168 width=30) (actual time=5.141..7.710 rows=168 loops=1)                                  |
--  Hash Cond: (m.movie_id = s.movie_id)                                                                                          |
--  ->  Seq Scan on movies m  (cost=0.00..184.00 rows=10000 width=15) (actual time=0.014..1.272 rows=10000 loops=1)               |
--  ->  Hash  (cost=501.78..501.78 rows=168 width=23) (actual time=5.089..5.093 rows=168 loops=1)                                 |
--        Buckets: 1024  Batches: 1  Memory Usage: 18kB                                                                           |
--        ->  Hash Join  (cost=236.10..501.78 rows=168 width=23) (actual time=2.051..5.017 rows=168 loops=1)                      |
--              Hash Cond: (h.hall_id = s.hall_id)                                                                                |
--              ->  Seq Scan on halls h  (cost=0.00..164.00 rows=10000 width=15) (actual time=0.007..1.397 rows=10000 loops=1)    |
--              ->  Hash  (cost=234.00..234.00 rows=168 width=16) (actual time=1.999..2.001 rows=168 loops=1)                     |
--                    Buckets: 1024  Batches: 1  Memory Usage: 16kB                                                               |
--                    ->  Seq Scan on seances s  (cost=0.00..234.00 rows=168 width=16) (actual time=0.019..1.908 rows=168 loops=1)|
--                          Filter: (start_time = CURRENT_DATE)                                                                   |
--                          Rows Removed by Filter: 9832                                                                          |
--Planning Time: 1.020 ms                                                                                                         |
--Execution Time: 7.777 ms                                                                                                        |

-- ДОБАВЛЯЕМ ИНДЕКС

CREATE INDEX start_date_index ON seances (start_time);

EXPLAIN ANALYZE SELECT
	h.name AS "Зал",
	m.title AS "Название фильма",
	s.start_time AS "Время начала"
FROM
	seances s
INNER JOIN halls h 
ON
	s.hall_id = h.hall_id
INNER JOIN movies m 
ON
	s.movie_id = m.movie_id
WHERE
	start_time = CURRENT_DATE;

--QUERY PLAN                                                                                                                         |
-----------------------------------------------------------------------------------------------------------------------------------+
--Nested Loop  (cost=0.57..813.25 rows=50 width=30) (actual time=0.030..3.222 rows=168 loops=1)                                      |
--  ->  Nested Loop  (cost=0.29..542.13 rows=50 width=23) (actual time=0.024..2.630 rows=168 loops=1)                                |
--        ->  Seq Scan on seances s  (cost=0.00..259.00 rows=50 width=16) (actual time=0.014..2.017 rows=168 loops=1)                |
--              Filter: (date(start_time) = CURRENT_DATE)                                                                            |
--              Rows Removed by Filter: 9832                                                                                         |
--        ->  Index Scan using movies_pkey on movies m  (cost=0.29..5.66 rows=1 width=15) (actual time=0.003..0.003 rows=1 loops=168)|
--              Index Cond: (movie_id = s.movie_id)                                                                                  |
--  ->  Index Scan using halls_pkey on halls h  (cost=0.29..5.42 rows=1 width=15) (actual time=0.003..0.003 rows=1 loops=168)        |
--        Index Cond: (hall_id = s.hall_id)                                                                                          |
--Planning Time: 1.044 ms                                                                                                            |
--Execution Time: 3.265 ms                                                                                                           |