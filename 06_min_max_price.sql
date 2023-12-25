-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

EXPLAIN SELECT min(price), max(price)  
FROM tickets t 
WHERE t.seance_id = 2;

--QUERY PLAN                                                     |
-----------------------------------------------------------------+
--Aggregate  (cost=199.01..199.02 rows=1 width=64)               |
--  ->  Seq Scan on tickets t  (cost=0.00..199.00 rows=2 width=5)|
--        Filter: (seance_id = 2)                                |

-- Создаем индекс
CREATE INDEX seance_id_index ON tickets (seance_id);

--QUERY PLAN                                                                        |
------------------------------------------------------------------------------------+
--Aggregate  (cost=11.35..11.36 rows=1 width=64)                                    |
--  ->  Bitmap Heap Scan on tickets t  (cost=4.30..11.34 rows=2 width=5)            |
--        Recheck Cond: (seance_id = 2)                                             |
--        ->  Bitmap Index Scan on seance_id_index  (cost=0.00..4.30 rows=2 width=0)|
--              Index Cond: (seance_id = 2)                                         |