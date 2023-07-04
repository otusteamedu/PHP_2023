EXPLAIN ANALYZE SELECT m.title
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date = CURRENT_DATE;
--                                                    QUERY PLAN                                                    
-----------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=0.29..213.30 rows=1 width=10) (actual time=0.631..0.633 rows=0 loops=1)
--   ->  Seq Scan on ticket_sales ts  (cost=0.00..205.00 rows=1 width=4) (actual time=0.631..0.632 rows=0 loops=1)
--         Filter: (sale_date = CURRENT_DATE)
--         Rows Removed by Filter: 10000
--   ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=14) (never executed)
--         Index Cond: (id = ts.movie_id)
-- Planning Time: 0.135 ms
-- Execution Time: 0.645 ms
-- (8 rows)

EXPLAIN ANALYZE SELECT COUNT(*) AS total_tickets_sold
FROM ticket_sales
WHERE sale_date >= CURRENT_DATE - INTERVAL '1 week';
--                                                    QUERY PLAN
-----------------------------------------------------------------------------------------------------------------
-- Aggregate  (cost=242.31..242.32 rows=1 width=8) (actual time=3.954..3.955 rows=1 loops=1)
--    ->  Seq Scan on ticket_sales  (cost=0.00..230.00 rows=4925 width=0) (actual time=0.013..3.495 rows=4925 loops=1)
--          Filter: (sale_date >= (CURRENT_DATE - '7 days'::interval))
--          Rows Removed by Filter: 5075
--  Planning Time: 0.086 ms
--  Execution Time: 3.982 ms
-- (6 rows)

EXPLAIN ANALYZE SELECT m.title, ts.sale_date
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date = CURRENT_DATE;
--                                                    QUERY PLAN
-----------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=0.29..213.30 rows=1 width=14) (actual time=1.460..1.461 rows=0 loops=1)
--    ->  Seq Scan on ticket_sales ts  (cost=0.00..205.00 rows=1 width=8) (actual time=1.459..1.460 rows=0 loops=1)
--          Filter: (sale_date = CURRENT_DATE)
--          Rows Removed by Filter: 10000
--    ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=14) (never executed)
--          Index Cond: (id = ts.movie_id)
--  Planning Time: 0.255 ms
--  Execution Time: 1.486 ms
-- (8 rows)

EXPLAIN ANALYZE SELECT m.title, SUM(ts.quantity) AS total_tickets_sold
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date >= CURRENT_DATE - INTERVAL '1 week'
GROUP BY m.title
ORDER BY total_tickets_sold DESC
LIMIT 3;
--                                                                QUERY PLAN                                                                 
-------------------------------------------------------------------------------------------------------------------------------------------
-- Limit  (cost=660.46..660.47 rows=3 width=18) (actual time=8.914..8.917 rows=3 loops=1)
--   ->  Sort  (cost=660.46..672.77 rows=4925 width=18) (actual time=8.908..8.910 rows=3 loops=1)
--         Sort Key: (sum(ts.quantity)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=547.55..596.80 rows=4925 width=18) (actual time=8.040..8.416 rows=3887 loops=1)
--               Group Key: m.title
--               Batches: 1  Memory Usage: 721kB
--               ->  Hash Join  (cost=280.00..522.93 rows=4925 width=14) (actual time=5.141..7.048 rows=4925 loops=1)
--                     Hash Cond: (ts.movie_id = m.id)
--                     ->  Seq Scan on ticket_sales ts  (cost=0.00..230.00 rows=4925 width=8) (actual time=0.025..1.276 rows=4925 loops=1)
--                           Filter: (sale_date >= (CURRENT_DATE - '7 days'::interval))
--                           Rows Removed by Filter: 5075
--                     ->  Hash  (cost=155.00..155.00 rows=10000 width=14) (actual time=5.054..5.054 rows=10000 loops=1)
--                           Buckets: 16384  Batches: 1  Memory Usage: 597kB
--                           ->  Seq Scan on movies m  (cost=0.00..155.00 rows=10000 width=14) (actual time=0.009..1.734 rows=10000 loops=1)
-- Planning Time: 0.631 ms
-- Execution Time: 9.099 ms
--(17 rows)

EXPLAIN ANALYZE SELECT hs.row_number, hs.seat_number,
       CASE WHEN ts.id IS NOT NULL THEN 'occupied' ELSE 'available' END AS status
FROM hall_schema hs
LEFT JOIN ticket_sales ts ON hs.id = ts.movie_id
                          AND ts.sale_date = '2023-06-28'
WHERE ts.movie_id = 5004      
ORDER BY hs.row_number, hs.seat_number;

--                                                                  QUERY PLAN                                                                  
----------------------------------------------------------------------------------------------------------------------------------------------
-- Sort  (cost=213.31..213.32 rows=1 width=40) (actual time=0.070..0.071 rows=0 loops=1)
--   Sort Key: hs.row_number, hs.seat_number
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=0.28..213.30 rows=1 width=40) (actual time=0.056..0.057 rows=0 loops=1)
--         ->  Index Scan using hall_schema_pkey on hall_schema hs  (cost=0.28..8.29 rows=1 width=12) (actual time=0.053..0.054 rows=0 loops=1)
--               Index Cond: (id = 5004)
--         ->  Seq Scan on ticket_sales ts  (cost=0.00..205.00 rows=1 width=8) (never executed)
--               Filter: ((movie_id = 5004) AND (sale_date = '2023-06-28'::date))
-- Planning Time: 0.413 ms
-- Execution Time: 0.135 ms
-- (10 rows)

