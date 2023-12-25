-- Формирование афиши (фильмы, которые показывают сегодня)

EXPLAIN ANALYZE SELECT
	h.title AS "Зал",
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
	start_date = CURRENT_DATE;

--QUERY PLAN                                                                                                                                   |
-----------------------------------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=392.44..674.37 rows=430 width=30) (actual time=2.481..3.843 rows=430 loops=1)                                               |
--  Hash Cond: (s.movie_id = m.movie_id)                                                                                                       |
--  ->  Hash Join  (cost=93.45..374.25 rows=430 width=23) (actual time=0.232..1.494 rows=430 loops=1)                                          |
--        Hash Cond: (h.hall_id = s.hall_id)                                                                                                   |
--        ->  Seq Scan on halls h  (cost=0.00..164.00 rows=10000 width=15) (actual time=0.004..0.513 rows=10000 loops=1)                       |
--        ->  Hash  (cost=88.07..88.07 rows=430 width=16) (actual time=0.221..0.222 rows=430 loops=1)                                          |
--              Buckets: 1024  Batches: 1  Memory Usage: 29kB                                                                                  |
--              ->  Bitmap Heap Scan on seances s  (cost=7.62..88.07 rows=430 width=16) (actual time=0.027..0.161 rows=430 loops=1)            |
--                    Recheck Cond: (start_date = CURRENT_DATE)                                                                                |
--                    Heap Blocks: exact=74                                                                                                    |
--                    ->  Bitmap Index Scan on start_time_index  (cost=0.00..7.51 rows=430 width=0) (actual time=0.015..0.015 rows=430 loops=1)|
--                          Index Cond: (start_date = CURRENT_DATE)                                                                            |
--  ->  Hash  (cost=174.00..174.00 rows=10000 width=15) (actual time=2.238..2.239 rows=10000 loops=1)                                          |
--        Buckets: 16384  Batches: 1  Memory Usage: 597kB                                                                                      |
--        ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15) (actual time=0.004..0.897 rows=10000 loops=1)                      |
--Planning Time: 0.264 ms                                                                                                                      |
--Execution Time: 3.883 ms                                                                                                                     |

CREATE INDEX start_time_index ON seances (start_date);

--QUERY PLAN                                                                                                                                   |
-----------------------------------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=392.44..674.37 rows=430 width=30) (actual time=1.803..2.774 rows=430 loops=1)                                               |
--  Hash Cond: (s.movie_id = m.movie_id)                                                                                                       |
--  ->  Hash Join  (cost=93.45..374.25 rows=430 width=23) (actual time=0.167..1.078 rows=430 loops=1)                                          |
--        Hash Cond: (h.hall_id = s.hall_id)                                                                                                   |
--        ->  Seq Scan on halls h  (cost=0.00..164.00 rows=10000 width=15) (actual time=0.002..0.369 rows=10000 loops=1)                       |
--        ->  Hash  (cost=88.07..88.07 rows=430 width=16) (actual time=0.159..0.160 rows=430 loops=1)                                          |
--              Buckets: 1024  Batches: 1  Memory Usage: 29kB                                                                                  |
--              ->  Bitmap Heap Scan on seances s  (cost=7.62..88.07 rows=430 width=16) (actual time=0.021..0.120 rows=430 loops=1)            |
--                    Recheck Cond: (start_date = CURRENT_DATE)                                                                                |
--                    Heap Blocks: exact=74                                                                                                    |
--                    ->  Bitmap Index Scan on start_time_index  (cost=0.00..7.51 rows=430 width=0) (actual time=0.012..0.012 rows=430 loops=1)|
--                          Index Cond: (start_date = CURRENT_DATE)                                                                            |
--  ->  Hash  (cost=174.00..174.00 rows=10000 width=15) (actual time=1.625..1.626 rows=10000 loops=1)                                          |
--        Buckets: 16384  Batches: 1  Memory Usage: 597kB                                                                                      |
--        ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15) (actual time=0.003..0.665 rows=10000 loops=1)                      |
--Planning Time: 0.192 ms                                                                                                                      |
--Execution Time: 2.802 ms                                                                                                                     |