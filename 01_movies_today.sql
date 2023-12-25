-- Выбор всех фильмов на сегодня

EXPLAIN ANALYZE SELECT
	m.title AS фильм
FROM
	seances s
INNER JOIN movies m 
ON
	m.movie_id = s.movie_id
WHERE s.start_date = CURRENT_DATE;

--QUERY PLAN                                                                                                        |
--------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=249.63..449.89 rows=50 width=11) (actual time=1.079..2.363 rows=493 loops=1)                     |
--  Hash Cond: (m.movie_id = s.movie_id)                                                                           |
--  ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15) (actual time=0.004..0.541 rows=10000 loops=1) |
--  ->  Hash  (cost=249.00..249.00 rows=50 width=4) (actual time=1.048..1.049 rows=493 loops=1)                     |
--        Buckets: 1024  Batches: 1  Memory Usage: 26kB                                                             |
--        ->  Seq Scan on seances s  (cost=0.00..249.00 rows=50 width=4) (actual time=0.013..0.990 rows=493 loops=1)|
--              Filter: ((start_time)::date = CURRENT_DATE)                                                         |
--              Rows Removed by Filter: 9507                                                                        |
--Planning Time: 0.152 ms                                                                                           |
--Execution Time: 2.391 ms                                                                                          |

-- Добавляем индекс
--
CREATE INDEX start_time_index ON seances (start_time);

--QUERY PLAN                                                                                                        |
--------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=207.75..294.83 rows=5 width=516) (actual time=1.233..2.923 rows=430 loops=1)                     |
--  Hash Cond: (m.movie_id = s.movie_id)                                                                           |
--  ->  Seq Scan on movies m  (cost=0.00..84.36 rows=1036 width=520) (actual time=0.010..0.852 rows=10000 loops=1)  |
--  ->  Hash  (cost=207.20..207.20 rows=44 width=4) (actual time=1.214..1.215 rows=430 loops=1)                     |
--        Buckets: 1024  Batches: 1  Memory Usage: 24kB                                                             |
--        ->  Seq Scan on seances s  (cost=0.00..207.20 rows=44 width=4) (actual time=0.010..1.164 rows=430 loops=1)|
--              Filter: (start_date = CURRENT_DATE)                                                                 |
--              Rows Removed by Filter: 9570                                                                        |
--Planning Time: 1.914 ms                                                                                           |
--Execution Time: 2.953 ms                                                                                          |

--Улучшений нет. Меняем структуру БД. Отдельно храним дату и время

-- Добавляем индекс

CREATE INDEX start_time_index ON seances (start_date);

--QUERY PLAN                                                                                                                       |
-----------------------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=306.62..388.20 rows=430 width=11) (actual time=1.680..1.823 rows=430 loops=1)                                   |
--  Hash Cond: (s.movie_id = m.movie_id)                                                                                           |
--  ->  Bitmap Heap Scan on seances s  (cost=7.62..88.07 rows=430 width=4) (actual time=0.034..0.117 rows=430 loops=1)             |
--        Recheck Cond: (start_date = CURRENT_DATE)                                                                                |
--        Heap Blocks: exact=74                                                                                                    |
--        ->  Bitmap Index Scan on start_time_index  (cost=0.00..7.51 rows=430 width=0) (actual time=0.024..0.024 rows=430 loops=1)|
--              Index Cond: (start_date = CURRENT_DATE)                                                                            |
--  ->  Hash  (cost=174.00..174.00 rows=10000 width=15) (actual time=1.631..1.632 rows=10000 loops=1)                              |
--        Buckets: 16384  Batches: 1  Memory Usage: 597kB                                                                          |
--        ->  Seq Scan on movies m  (cost=0.00..174.00 rows=10000 width=15) (actual time=0.004..0.664 rows=10000 loops=1)          |
--Planning Time: 0.126 ms                                                                                                          |
--Execution Time: 1.848 ms                                                                                                         |
