-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

EXPLAIN ANALYZE SELECT
	halls.name,
	places.number_row,
	places.number_places,
	places.place_id IN (SELECT place_id FROM tickets WHERE tickets.seance_id = seances.seance_id) AS is_busy
FROM
	places
INNER JOIN halls
ON
	places.hall_id = halls.hall_id
INNER  JOIN seances 
ON
	halls.hall_id = seances.hall_id
WHERE
	seances.seance_id = 72;

--QUERY PLAN                                                                                                                          |
------------------------------------------------------------------------------------------------------------------------------------+
--Hash Join  (cost=297.31..1014582.29 rows=100 width=20) (actual time=222.899..3578.050 rows=107 loops=1)                             |
--  Hash Cond: (places.hall_id = seances.hall_id)                                                                                     |
--  ->  Hash Join  (cost=289.00..19285.11 rows=1000000 width=31) (actual time=2.659..237.355 rows=1000000 loops=1)                    |
--        Hash Cond: (places.hall_id = halls.hall_id)                                                                                 |
--        ->  Seq Scan on places  (cost=0.00..16370.00 rows=1000000 width=16) (actual time=0.061..96.929 rows=1000000 loops=1)        |
--        ->  Hash  (cost=164.00..164.00 rows=10000 width=15) (actual time=2.568..2.570 rows=10000 loops=1)                           |
--              Buckets: 16384  Batches: 1  Memory Usage: 597kB                                                                       |
--              ->  Seq Scan on halls  (cost=0.00..164.00 rows=10000 width=15) (actual time=0.019..1.641 rows=10000 loops=1)          |
--  ->  Hash  (cost=8.30..8.30 rows=1 width=8) (actual time=126.036..126.037 rows=1 loops=1)                                          |
--        Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                |
--        ->  Index Scan using seances_pkey on seances  (cost=0.29..8.30 rows=1 width=8) (actual time=126.014..126.018 rows=1 loops=1)|
--              Index Cond: (seance_id = 72)                                                                                          |
--  SubPlan 1                                                                                                                         |
--    ->  Seq Scan on tickets  (cost=0.00..19853.00 rows=100 width=4) (actual time=0.021..29.555 rows=87 loops=107)                   |
--          Filter: (seance_id = seances.seance_id)                                                                                   |
--          Rows Removed by Filter: 994227                                                                                            |
--Planning Time: 2.062 ms                                                                                                             |
--JIT:                                                                                                                                |
--  Functions: 28                                                                                                                     |
--  Options: Inlining true, Optimization true, Expressions true, Deforming true                                                       |
--  Timing: Generation 9.934 ms, Inlining 18.431 ms, Optimization 68.639 ms, Emission 38.733 ms, Total 135.738 ms                     |
--Execution Time: 3588.882 ms                                                                                                         |

--ДОБАВЛЯЕМ ИНДЕКС
CREATE INDEX seance_id_index ON tickets (seance_id);

explain analyze SELECT
	halls.name,
	places.number_row,
	places.number_places,
	places.place_id IN (SELECT place_id FROM tickets WHERE tickets.seance_id = seances.seance_id) AS is_busy
FROM
	places
INNER JOIN halls
ON
	places.hall_id = halls.hall_id
INNER  JOIN seances 
ON
	halls.hall_id = seances.hall_id
WHERE
	seances.seance_id = 72;
	
--QUERY PLAN                                                                                                                                  |
--------------------------------------------------------------------------------------------------------------------------------------------+
--Gather  (cost=1008.60..31507.89 rows=100 width=20) (actual time=2.653..50.363 rows=107 loops=1)                                             |
--  Workers Planned: 2                                                                                                                        |
--  Workers Launched: 2                                                                                                                       |
--  ->  Nested Loop  (cost=8.60..11651.92 rows=42 width=27) (actual time=2.009..34.095 rows=36 loops=3)                                       |
--        ->  Hash Join  (cost=8.31..11639.20 rows=42 width=24) (actual time=1.995..34.005 rows=36 loops=3)                                   |
--              Hash Cond: (places.hall_id = seances.hall_id)                                                                                 |
--              ->  Parallel Seq Scan on places  (cost=0.00..10536.67 rows=416667 width=16) (actual time=0.010..16.880 rows=333333 loops=3)   |
--              ->  Hash  (cost=8.30..8.30 rows=1 width=8) (actual time=0.029..0.030 rows=1 loops=3)                                          |
--                    Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                            |
--                    ->  Index Scan using seances_pkey on seances  (cost=0.29..8.30 rows=1 width=8) (actual time=0.025..0.025 rows=1 loops=3)|
--                          Index Cond: (seance_id = 72)                                                                                      |
--        ->  Index Scan using halls_pkey on halls  (cost=0.29..0.30 rows=1 width=15) (actual time=0.002..0.002 rows=1 loops=107)             |
--              Index Cond: (hall_id = places.hall_id)                                                                                        |
--  SubPlan 1                                                                                                                                 |
--    ->  Bitmap Heap Scan on tickets  (cost=5.20..371.46 rows=100 width=4) (actual time=0.011..0.042 rows=87 loops=107)                      |
--          Recheck Cond: (seance_id = seances.seance_id)                                                                                     |
--          Heap Blocks: exact=9186                                                                                                           |
--          ->  Bitmap Index Scan on seance_id_index  (cost=0.00..5.17 rows=100 width=0) (actual time=0.008..0.008 rows=87 loops=107)         |
--                Index Cond: (seance_id = seances.seance_id)                                                                                 |
--Planning Time: 1.067 ms                                                                                                                     |
--Execution Time: 50.409 ms                                                                                                                   |