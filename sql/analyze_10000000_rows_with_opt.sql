-- Индекс для ускорения соединения таблиц и фильтрации по дате продажи
CREATE INDEX idx_ticket_sales_sale_date ON ticket_sales (sale_date);

-- Индекс для ускорения группировки, сортировки и ограничения результатов запроса
CREATE INDEX idx_ticket_sales_movie_date_quantity ON ticket_sales (movie_id, sale_date, quantity);

-- Индекс для ускорения соединения таблиц hall_schema и ticket_sales
CREATE INDEX idx_ticket_sales_movie_date ON ticket_sales (movie_id, sale_date);



EXPLAIN ANALYZE SELECT m.title
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date = CURRENT_DATE;
--                                                                    QUERY PLAN                                                                    
----------------------------------------------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=0.87..16.91 rows=1 width=13) (actual time=0.013..0.014 rows=0 loops=1)
--   ->  Index Scan using idx_ticket_sales_sale_date on ticket_sales ts  (cost=0.44..8.46 rows=1 width=4) (actual time=0.013..0.013 rows=0 loops=1)
--         Index Cond: (sale_date = CURRENT_DATE)
--   ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=17) (never executed)
--         Index Cond: (id = ts.movie_id)
-- Planning Time: 3.686 ms
-- Execution Time: 0.029 ms
--(7 rows)



EXPLAIN ANALYZE SELECT COUNT(*) AS total_tickets_sold
FROM ticket_sales
WHERE sale_date >= CURRENT_DATE - INTERVAL '1 week';
--                                                                                        QUERY PLAN                                                                                        
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Finalize Aggregate  (cost=82090.13..82090.14 rows=1 width=8) (actual time=165.679..170.981 rows=1 loops=1)
--   ->  Gather  (cost=82089.92..82090.13 rows=2 width=8) (actual time=165.590..170.974 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=81089.92..81089.93 rows=1 width=8) (actual time=149.056..149.057 rows=1 loops=3)
--               ->  Parallel Index Only Scan using idx_ticket_sales_sale_date on ticket_sales  (cost=0.44..75841.27 rows=2099458 width=0) (actual time=0.044..92.308 rows=1668060 loops=3)
--                     Index Cond: (sale_date >= (CURRENT_DATE - '7 days'::interval))
--                     Heap Fetches: 0
-- Planning Time: 0.230 ms
-- Execution Time: 171.043 ms
-- (10 rows)

EXPLAIN ANALYZE SELECT m.title, ts.sale_date
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date = CURRENT_DATE;
--                                                                    QUERY PLAN                                                                    
--------------------------------------------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=0.87..16.91 rows=1 width=17) (actual time=0.022..0.024 rows=0 loops=1)
--   ->  Index Scan using idx_ticket_sales_sale_date on ticket_sales ts  (cost=0.44..8.46 rows=1 width=8) (actual time=0.021..0.022 rows=0 loops=1)
--         Index Cond: (sale_date = CURRENT_DATE)
--   ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=17) (never executed)
--         Index Cond: (id = ts.movie_id)
-- Planning Time: 0.633 ms
-- Execution Time: 0.068 ms
--(7 rows)



EXPLAIN ANALYZE SELECT m.title, SUM(ts.quantity) AS total_tickets_sold
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date >= CURRENT_DATE - INTERVAL '1 week'
GROUP BY m.title
ORDER BY total_tickets_sold DESC
LIMIT 3;
--                                                                      QUERY PLAN                                                                      
------------------------------------------------------------------------------------------------------------------------------------------------------
-- Limit  (cost=1224743.07..1224743.07 rows=3 width=21) (actual time=8645.654..8645.658 rows=3 loops=1)
--   ->  Sort  (cost=1224743.07..1237339.65 rows=5038633 width=21) (actual time=8549.103..8549.106 rows=3 loops=1)
--         Sort Key: (sum(ts.quantity)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=1050186.87..1159619.68 rows=5038633 width=21) (actual time=6905.743..8125.200 rows=3935628 loops=1)
--               Group Key: m.title
--               Planned Partitions: 128  Batches: 129  Memory Usage: 8209kB  Disk Usage: 253472kB
--               ->  Hash Join  (cost=347512.03..688035.12 rows=5038633 width=17) (actual time=2168.442..5532.137 rows=5004181 loops=1)
--                     Hash Cond: (ts.movie_id = m.id)
--                     ->  Seq Scan on ticket_sales ts  (cost=0.00..229281.67 rows=5038633 width=8) (actual time=0.039..1147.552 rows=5004181 loops=1)
--                           Filter: (sale_date >= (CURRENT_DATE - '7 days'::interval))
--                           Rows Removed by Filter: 5005819
--                     ->  Hash  (cost=163745.79..163745.79 rows=10009379 width=17) (actual time=2167.316..2167.317 rows=10010000 loops=1)
--                           Buckets: 131072  Batches: 128  Memory Usage: 5006kB
--                           ->  Seq Scan on movies m  (cost=0.00..163745.79 rows=10009379 width=17) (actual time=0.024..646.350 rows=10010000 loops=1)
-- Planning Time: 0.758 ms
-- JIT:
--   Functions: 21
--   Options: Inlining true, Optimization true, Expressions true, Deforming true
--   Timing: Generation 2.423 ms, Inlining 31.421 ms, Optimization 60.672 ms, Emission 29.377 ms, Total 123.893 ms
-- Execution Time: 8681.547 ms
--(21 rows)

EXPLAIN ANALYZE SELECT hs.row_number, hs.seat_number,
       CASE WHEN ts.id IS NOT NULL THEN 'occupied' ELSE 'available' END AS status
FROM hall_schema hs
LEFT JOIN ticket_sales ts ON hs.id = ts.movie_id
                          AND ts.sale_date = '2023-06-28'
WHERE ts.movie_id = 5004      
ORDER BY hs.row_number, hs.seat_number;

--                                                                  QUERY PLAN                                                                  
----------------------------------------------------------------------------------------------------------------------------------------------
-- Sort  (cost=117679.08..117679.09 rows=1 width=40) (actual time=0.021..0.023 rows=0 loops=1)
--   Sort Key: hs.row_number, hs.seat_number
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=1000.27..117679.07 rows=1 width=40) (actual time=0.013..0.014 rows=0 loops=1)
--         ->  Index Scan using hall_schema_pkey on hall_schema hs  (cost=0.28..8.29 rows=1 width=12) (actual time=0.012..0.013 rows=0 loops=1)
--               Index Cond: (id = 5004)
--         ->  Gather  (cost=1000.00..117670.77 rows=1 width=8) (never executed)
--               Workers Planned: 2
--               Workers Launched: 0
--               ->  Parallel Seq Scan on ticket_sales ts  (cost=0.00..116670.67 rows=1 width=8) (never executed)
--                     Filter: ((movie_id = 5004) AND (sale_date = '2023-06-28'::date))
-- Planning Time: 0.306 ms
-- JIT:
--   Functions: 8
--   Options: Inlining false, Optimization false, Expressions true, Deforming true
--   Timing: Generation 0.741 ms, Inlining 0.000 ms, Optimization 0.000 ms, Emission 0.000 ms, Total 0.741 ms
-- Execution Time: 0.992 ms
--(17 rows)
