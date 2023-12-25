-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

EXPLAIN ANALYZE SELECT min(price), max(price)  
FROM tickets t 
WHERE t.seance_id = 2;

--QUERY PLAN                                                                                               |
-----------------------------------------------------------------------------------------------------------+
--Aggregate  (cost=199.01..199.02 rows=1 width=64) (actual time=0.538..0.539 rows=1 loops=1)               |
--  ->  Seq Scan on tickets t  (cost=0.00..199.00 rows=2 width=5) (actual time=0.536..0.536 rows=0 loops=1)|
--        Filter: (seance_id = 2)                                                                          |
--        Rows Removed by Filter: 10000                                                                    |
--Planning Time: 0.789 ms                                                                                  |
--Execution Time: 0.559 ms                                                                                 |

-- Создаем индекс
CREATE INDEX seance_id_index ON tickets (seance_id);

--QUERY PLAN                                                                                                                  |
------------------------------------------------------------------------------------------------------------------------------+
--Aggregate  (cost=17.60..17.61 rows=1 width=64) (actual time=0.028..0.029 rows=1 loops=1)                                    |
--  ->  Bitmap Heap Scan on tickets t  (cost=4.32..17.58 rows=4 width=5) (actual time=0.016..0.021 rows=4 loops=1)            |
--        Recheck Cond: (seance_id = 2)                                                                                       |
--        Heap Blocks: exact=4                                                                                                |
--        ->  Bitmap Index Scan on seance_id_index  (cost=0.00..4.32 rows=4 width=0) (actual time=0.012..0.012 rows=4 loops=1)|
--              Index Cond: (seance_id = 2)                                                                                   |
--Planning Time: 0.097 ms                                                                                                     |
--Execution Time: 0.052 ms                                                                                                    |
