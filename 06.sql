-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

DROP INDEX seance_id_index;

EXPLAIN ANALYZE SELECT min(price), max(price)  
FROM tickets t 
WHERE t.seance_id = 72;


--QUERY PLAN                                                                                                                         |
-----------------------------------------------------------------------------------------------------------------------------------+
--Finalize Aggregate  (cost=13561.76..13561.77 rows=1 width=64) (actual time=72.613..76.691 rows=1 loops=1)                          |
--  ->  Gather  (cost=13561.54..13561.75 rows=2 width=64) (actual time=71.474..76.684 rows=3 loops=1)                                |
--        Workers Planned: 2                                                                                                         |
--        Workers Launched: 2                                                                                                        |
--        ->  Partial Aggregate  (cost=12561.54..12561.55 rows=1 width=64) (actual time=23.366..23.367 rows=1 loops=3)               |
--              ->  Parallel Seq Scan on tickets t  (cost=0.00..12561.33 rows=42 width=5) (actual time=0.857..23.328 rows=29 loops=3)|
--                    Filter: (seance_id = 72)                                                                                       |
--                    Rows Removed by Filter: 333304                                                                                 |
--Planning Time: 0.223 ms                                                                                                            |
--Execution Time: 76.766 ms                                                                                                          |

--ДОБАВЛЯЕМ ИНДЕКС
CREATE INDEX seance_id_index ON tickets (seance_id);
EXPLAIN ANALYZE SELECT min(price), max(price)  
FROM tickets t 
WHERE t.seance_id = 72;

--QUERY PLAN                                                                                                                     |
-------------------------------------------------------------------------------------------------------------------------------+
--Aggregate  (cost=371.96..371.97 rows=1 width=64) (actual time=0.353..0.353 rows=1 loops=1)                                     |
--  ->  Bitmap Heap Scan on tickets t  (cost=5.20..371.46 rows=100 width=5) (actual time=0.215..0.337 rows=87 loops=1)           |
--        Recheck Cond: (seance_id = 72)                                                                                         |
--        Heap Blocks: exact=86                                                                                                  |
--        ->  Bitmap Index Scan on seance_id_index  (cost=0.00..5.17 rows=100 width=0) (actual time=0.192..0.192 rows=87 loops=1)|
--              Index Cond: (seance_id = 72)                                                                                     |
--Planning Time: 0.952 ms                                                                                                        |
--Execution Time: 0.368 ms                                                                                                       |