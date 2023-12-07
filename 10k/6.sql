--Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN ANALYSE
SELECT min(t.price) as min_price,
       max(t.price) as max_price
FROM tickets as t
WHERE showtime_id = 1;

-- Aggregate  (cost=176.22..176.23 rows=1 width=64) (actual time=2.775..2.776 rows=1 loops=1)
--   ->  Seq Scan on tickets t  (cost=0.00..176.00 rows=45 width=14) (actual time=0.036..2.604 rows=108 loops=1)
--         Filter: (showtime_id = 1)
--         Rows Removed by Filter: 9892
-- Planning Time: 0.284 ms
-- Execution Time: 2.845 ms

create index idx_price ON tickets (price);

-- Result  (cost=23.57..23.58 rows=1 width=64) (actual time=0.408..0.409 rows=1 loops=1)
--   InitPlan 1 (returns $0)
--     ->  Limit  (cost=0.29..11.79 rows=1 width=14) (actual time=0.178..0.178 rows=1 loops=1)
--           ->  Index Scan using idx_price on tickets t  (cost=0.29..575.28 rows=50 width=14) (actual time=0.176..0.177 rows=1 loops=1)
--                 Index Cond: (price IS NOT NULL)
--                 Filter: (showtime_id = 1)
--   InitPlan 2 (returns $1)
--     ->  Limit  (cost=0.29..11.79 rows=1 width=14) (actual time=0.222..0.222 rows=1 loops=1)
--           ->  Index Scan Backward using idx_price on tickets t_1  (cost=0.29..575.28 rows=50 width=14) (actual time=0.221..0.221 rows=1 loops=1)
--                 Index Cond: (price IS NOT NULL)
--                 Filter: (showtime_id = 1)
--                 Rows Removed by Filter: 44
-- Planning Time: 1.345 ms
-- Execution Time: 0.454 ms
