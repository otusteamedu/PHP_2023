-- Выбор всех фильмов на сегодня

EXPLAIN ANALYZE SELECT
	m.title AS фильм
FROM
	seances s
INNER JOIN movies m 
ON
	m.movie_id = s.movie_id
WHERE s.start_time = CURRENT_DATE;


--QUERY PLAN                                                                                                         |
-------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=236.10..521.78 rows=168 width=11) (actual time=1.892..4.727 rows=168 loops=1)                     |
--  Hash Cond: (m.movie_id = s.movie_id)                                                                             |
--  ->  Seq Scan on movies m  (cost=0.00..184.00 rows=10000 width=15) (actual time=0.015..1.549 rows=10000 loops=1)  |
--  ->  Hash  (cost=234.00..234.00 rows=168 width=4) (actual time=1.845..1.846 rows=168 loops=1)                     |
--        Buckets: 1024  Batches: 1  Memory Usage: 14kB                                                              |
--        ->  Seq Scan on seances s  (cost=0.00..234.00 rows=168 width=4) (actual time=0.015..1.762 rows=168 loops=1)|
--              Filter: (start_time = CURRENT_DATE)                                                                  |
--              Rows Removed by Filter: 9832                                                                         |
--Planning Time: 1.046 ms                                                                                            |
--Execution Time: 4.798 ms                                                                                           |



-- ДОБАВЛЯЕМ ИНДЕКС

CREATE INDEX movie_date_index ON seances (start_time);

EXPLAIN ANALYZE SELECT
	m.title AS фильм
FROM
	seances s
INNER JOIN movies m 
ON
	m.movie_id = s.movie_id
WHERE s.start_time = CURRENT_DATE;

--QUERY PLAN                                                                                                                             |
---------------------------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=94.21..379.89 rows=168 width=11) (actual time=0.272..1.172 rows=168 loops=1)                                          |
--  Hash Cond: (m.movie_id = s.movie_id)                                                                                                 |
--  ->  Seq Scan on movies m  (cost=0.00..184.00 rows=10000 width=15) (actual time=0.003..0.423 rows=10000 loops=1)                      |
--  ->  Hash  (cost=92.11..92.11 rows=168 width=4) (actual time=0.258..0.258 rows=168 loops=1)                                           |
--        Buckets: 1024  Batches: 1  Memory Usage: 14kB                                                                                  |
--        ->  Bitmap Heap Scan on seances s  (cost=5.59..92.11 rows=168 width=4) (actual time=0.156..0.243 rows=168 loops=1)             |
--              Recheck Cond: (start_time = CURRENT_DATE)                                                                                |
--              Heap Blocks: exact=74                                                                                                    |
--              ->  Bitmap Index Scan on start_time_index  (cost=0.00..5.55 rows=168 width=0) (actual time=0.147..0.147 rows=168 loops=1)|
--                    Index Cond: (start_time = CURRENT_DATE)                                                                            |
--Planning Time: 0.496 ms                                                                                                                |
--Execution Time: 1.190 ms                                                                                                               |