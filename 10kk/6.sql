--Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN ANALYSE
SELECT min(t.price) as min_price,
       max(t.price) as max_price
FROM tickets as t
WHERE showtime_id = 1;

-- Finalize Aggregate  (cost=12580.63..12580.64 rows=1 width=64) (actual time=20.741..23.763 rows=1 loops=1)
--   ->  Gather  (cost=12580.41..12580.62 rows=2 width=64) (actual time=20.623..23.757 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=11580.41..11580.42 rows=1 width=64) (actual time=15.867..15.868 rows=1 loops=3)
--               ->  Parallel Seq Scan on tickets t  (cost=0.00..11578.33 rows=415 width=5) (actual time=0.090..15.784 rows=342 loops=3)
--                     Filter: (showtime_id = 1)
--                     Rows Removed by Filter: 332991
-- Planning Time: 3.965 ms
-- Execution Time: 23.815 ms

create index idx_price ON tickets (price);

-- Result  (cost=114.36..114.37 rows=1 width=64) (actual time=13.858..13.861 rows=1 loops=1)
--   InitPlan 1 (returns $0)
--     ->  Limit  (cost=0.42..57.18 rows=1 width=5) (actual time=2.084..2.086 rows=1 loops=1)
--           ->  Index Scan using idx_price on tickets t  (cost=0.42..56472.30 rows=995 width=5) (actual time=2.081..2.082 rows=1 loops=1)
--                 Index Cond: (price IS NOT NULL)
--                 Filter: (showtime_id = 1)
--                 Rows Removed by Filter: 968
--   InitPlan 2 (returns $1)
--     ->  Limit  (cost=0.42..57.18 rows=1 width=5) (actual time=11.757..11.758 rows=1 loops=1)
--           ->  Index Scan Backward using idx_price on tickets t_1  (cost=0.42..56472.30 rows=995 width=5) (actual time=11.756..11.756 rows=1 loops=1)
--                 Index Cond: (price IS NOT NULL)
--                 Filter: (showtime_id = 1)
--                 Rows Removed by Filter: 3639
-- Planning Time: 10.982 ms
-- Execution Time: 13.994 ms
