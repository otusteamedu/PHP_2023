EXPLAIN ANALYZE SELECT m.title
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date = CURRENT_DATE;
--                                                               QUERY PLAN                                                               
-- ---------------------------------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=1000.43..117679.22 rows=1 width=13) (actual time=232.328..239.200 rows=0 loops=1)
--   ->  Gather  (cost=1000.00..117670.77 rows=1 width=4) (actual time=232.327..239.198 rows=0 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Parallel Seq Scan on ticket_sales ts  (cost=0.00..116670.67 rows=1 width=4) (actual time=175.479..175.479 rows=0 loops=3)
--               Filter: (sale_date = CURRENT_DATE)
--               Rows Removed by Filter: 3336667
--   ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=17) (never executed)
--         Index Cond: (id = ts.movie_id)
-- Planning Time: 0.820 ms
-- JIT:
--   Functions: 17
--   Options: Inlining false, Optimization false, Expressions true, Deforming true
--   Timing: Generation 1.160 ms, Inlining 0.000 ms, Optimization 0.526 ms, Emission 10.783 ms, Total 12.469 ms
-- Execution Time: 239.594 ms
--(15 rows)

CREATE INDEX idx_ticket_sales_sale_date ON ticket_sales (sale_date);
--                                                                     QUERY PLAN                                                                    
--------------------------------------------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=0.87..16.91 rows=1 width=13) (actual time=0.056..0.057 rows=0 loops=1)
--   ->  Index Scan using idx_ticket_sales_sale_date on ticket_sales ts  (cost=0.44..8.46 rows=1 width=4) (actual time=0.055..0.055 rows=0 loops=1)
--         Index Cond: (sale_date = CURRENT_DATE)
--   ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=17) (never executed)
--         Index Cond: (id = ts.movie_id)
-- Planning Time: 0.813 ms
-- Execution Time: 0.097 ms
-- (7 rows)

-- Вывод: индексирование ускоряет запрос в 2.5 раза

EXPLAIN ANALYZE SELECT COUNT(*) AS total_tickets_sold
FROM ticket_sales
WHERE sale_date >= CURRENT_DATE - INTERVAL '1 week';
--                                                                     QUERY PLAN                                                                     
------------------------------------------------------------------------------------------------------------------------------------------------------
-- Finalize Aggregate  (cost=133346.40..133346.41 rows=1 width=8) (actual time=504.319..508.054 rows=1 loops=1)
--   ->  Gather  (cost=133346.19..133346.40 rows=2 width=8) (actual time=504.131..508.036 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=132346.19..132346.20 rows=1 width=8) (actual time=490.147..490.149 rows=1 loops=3)
--               ->  Parallel Seq Scan on ticket_sales  (cost=0.00..127097.61 rows=2099430 width=0) (actual time=4.244..432.453 rows=1668060 loops=3)
--                     Filter: (sale_date >= (CURRENT_DATE - '7 days'::interval))
--                     Rows Removed by Filter: 1668606
-- Planning Time: 0.395 ms
-- JIT:
--   Functions: 14
--   Options: Inlining false, Optimization false, Expressions true, Deforming true
--   Timing: Generation 3.531 ms, Inlining 0.000 ms, Optimization 0.498 ms, Emission 12.244 ms, Total 16.274 ms
-- Execution Time: 509.015 ms
-- (14 rows)

CREATE INDEX idx_ticket_sales_sale_date ON ticket_sales (sale_date);
--                                                                                         QUERY PLAN                                                                                        
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Finalize Aggregate  (cost=80056.22..80056.23 rows=1 width=8) (actual time=162.069..164.732 rows=1 loops=1)
--   ->  Gather  (cost=80056.00..80056.21 rows=2 width=8) (actual time=161.975..164.726 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=79056.00..79056.01 rows=1 width=8) (actual time=142.224..142.225 rows=1 loops=3)
--               ->  Parallel Index Only Scan using idx_ticket_sales_sale_date on ticket_sales  (cost=0.44..73938.99 rows=2046805 width=0) (actual time=0.091..85.863 rows=1665934 loops=3)
--                     Index Cond: (sale_date >= (CURRENT_DATE - '7 days'::interval))
--                     Heap Fetches: 0
-- Planning Time: 0.416 ms
-- Execution Time: 164.790 ms
-- (10 rows)

-- Вывод: индексирование ускоряет запрос в 3 раза

EXPLAIN ANALYZE SELECT movies.title, values.date_value AS start_time
FROM movies
JOIN "values" ON "values".movie_id = movies.id
JOIN attributes ON attributes.id = "values".attribute_id
JOIN attribute_types ON attribute_types.id = "values".attribute_type_id
WHERE attributes.name = 'Время начала'
  AND attribute_types.name = 'Дата/Время'
  AND "values".date_value::date = CURRENT_DATE;

--                                                                       QUERY PLAN                                                                        
---------------------------------------------------------------------------------------------------------------------------------------------------------
-- Nested Loop  (cost=1001.29..116816.43 rows=1 width=17) (actual time=205.015..207.314 rows=0 loops=1)
--   ->  Nested Loop  (cost=1000.85..116799.96 rows=1 width=21) (actual time=205.014..207.313 rows=0 loops=1)
--         ->  Nested Loop  (cost=1000.42..116791.50 rows=1 width=12) (actual time=205.014..207.312 rows=0 loops=1)
--               ->  Gather  (cost=1000.00..116779.03 rows=1 width=4) (actual time=18.820..206.552 rows=1 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Parallel Seq Scan on attributes  (cost=0.00..115778.93 rows=1 width=4) (actual time=119.537..181.282 rows=0 loops=3)
--                           Filter: (name = 'Время начала'::text)
--                           Rows Removed by Filter: 3333333
--               ->  Index Scan using unique_start_time_per_hall on "values"  (cost=0.42..12.46 rows=1 width=16) (actual time=0.752..0.752 rows=0 loops=1)
--                     Index Cond: (attribute_id = attributes.id)
--                     Filter: (date_value = CURRENT_DATE)
--                     Rows Removed by Filter: 1
--         ->  Index Scan using movies_pkey on movies  (cost=0.43..8.45 rows=1 width=17) (never executed)
--               Index Cond: (id = "values".movie_id)
--   ->  Index Scan using attribute_types_pkey on attribute_types  (cost=0.43..8.46 rows=1 width=4) (never executed)
--         Index Cond: (id = "values".attribute_type_id)
--         Filter: (name = 'Дата/Время'::text)
-- Planning Time: 8.428 ms
-- --JIT:
--   Functions: 30
--   Options: Inlining false, Optimization false, Expressions true, Deforming true
--   Timing: Generation 8.650 ms, Inlining 0.000 ms, Optimization 1.885 ms, Emission 22.766 ms, Total 33.301 ms
-- Execution Time: 214.820 ms
-- (24 rows)


CREATE INDEX idx_movies_id ON movies (id);
CREATE INDEX idx_attributes_name ON attributes (name);
CREATE INDEX idx_attribute_types_id ON attribute_types (id);
CREATE INDEX idx_values_attribute_id ON "values" (attribute_id);
CREATE INDEX idx_values_attribute_type_id ON "values" (attribute_type_id);
CREATE INDEX idx_values_date_value ON "values" (date_value);

--                                                                     QUERY PLAN                                                                     
---------------------------------------------------------------------------------------------------------------------------------------------------
--  Nested Loop  (cost=1.87..41.97 rows=1 width=17) (actual time=0.043..0.044 rows=0 loops=1)
--    ->  Nested Loop  (cost=1.43..25.50 rows=1 width=21) (actual time=0.042..0.043 rows=0 loops=1)
--          Join Filter: ("values".attribute_id = attributes.id)
--          ->  Nested Loop  (cost=0.87..16.91 rows=1 width=25) (actual time=0.042..0.043 rows=0 loops=1)
--                ->  Index Scan using idx_values_date_value on "values"  (cost=0.44..8.46 rows=1 width=16) (actual time=0.041..0.042 rows=0 loops=1)
--                      Index Cond: (date_value = CURRENT_DATE)
--                ->  Index Scan using idx_movies_id on movies  (cost=0.43..8.45 rows=1 width=17) (never executed)
--                      Index Cond: (id = "values".movie_id)
--          ->  Index Scan using idx_attributes_name on attributes  (cost=0.56..8.58 rows=1 width=4) (never executed)
--                Index Cond: (name = 'Время начала'::text)
--    ->  Index Scan using idx_attribute_types_id on attribute_types  (cost=0.43..8.46 rows=1 width=4) (never executed)
--          Index Cond: (id = "values".attribute_type_id)
--          Filter: (name = 'Дата/Время'::text)
--  Planning Time: 2.953 ms
--  Execution Time: 0.163 ms
-- (15 rows)

-- вывод: индексирование ускоряет запрос в 130 раз


EXPLAIN ANALYZE SELECT m.title, SUM(ts.quantity) AS total_tickets_sold
FROM movies m
JOIN ticket_sales ts ON m.id = ts.movie_id
WHERE ts.sale_date >= CURRENT_DATE - INTERVAL '1 week'
GROUP BY m.title
ORDER BY total_tickets_sold DESC
LIMIT 3;

--                                                                                      QUERY PLAN                                                                                       
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=1292917.46..1292917.47 rows=3 width=21) (actual time=10765.613..10844.650 rows=3 loops=1)
--    ->  Sort  (cost=1292917.46..1305198.30 rows=4912333 width=21) (actual time=10559.341..10638.377 rows=3 loops=1)
--          Sort Key: (sum(ts.quantity)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=651511.85..1229426.48 rows=4912333 width=21) (actual time=6419.587..10165.133 rows=3933386 loops=1)
--                Group Key: m.title
--                ->  Gather Merge  (cost=651511.85..1159835.10 rows=4093610 width=21) (actual time=6419.561..9216.790 rows=3933386 loops=1)
--                      Workers Planned: 2
--                      Workers Launched: 2
--                      ->  Partial GroupAggregate  (cost=650511.82..686330.91 rows=2046805 width=21) (actual time=6364.292..7756.726 rows=1311129 loops=3)
--                            Group Key: m.title
--                            ->  Sort  (cost=650511.82..655628.84 rows=2046805 width=17) (actual time=6364.260..7378.017 rows=1665934 loops=3)
--                                  Sort Key: m.title
--                                  Sort Method: external merge  Disk: 48736kB
--                                  Worker 0:  Sort Method: external merge  Disk: 49016kB
--                                  Worker 1:  Sort Method: external merge  Disk: 48936kB
--                                  ->  Parallel Hash Join  (cost=160552.73..352005.08 rows=2046805 width=17) (actual time=1731.649..3051.483 rows=1665934 loops=3)
--                                        Hash Cond: (m.id = ts.movie_id)
--                                        ->  Parallel Seq Scan on movies m  (cost=0.00..105264.67 rows=4166667 width=17) (actual time=0.075..207.780 rows=3333333 loops=3)
--                                        ->  Parallel Hash  (cost=126971.67..126971.67 rows=2046805 width=8) (actual time=803.371..803.372 rows=1665934 loops=3)
--                                              Buckets: 131072  Batches: 128  Memory Usage: 2592kB
--                                              ->  Parallel Seq Scan on ticket_sales ts  (cost=0.00..126971.67 rows=2046805 width=8) (actual time=122.198..491.860 rows=1665934 loops=3)
--                                                    Filter: (sale_date >= (CURRENT_DATE - '7 days'::interval))
--                                                    Rows Removed by Filter: 1667400
--  Planning Time: 1.194 ms
--  JIT:
--    Functions: 55
--    Options: Inlining true, Optimization true, Expressions true, Deforming true
--    Timing: Generation 9.485 ms, Inlining 190.770 ms, Optimization 240.076 ms, Emission 142.164 ms, Total 582.495 ms
--  Execution Time: 10852.806 ms
-- (30 rows)

CREATE INDEX idx_ticket_sales_sale_date ON ticket_sales (sale_date);
CREATE INDEX idx_movies_id ON movies (id);
CREATE INDEX idx_ticket_sales_movie_id ON ticket_sales (movie_id);

--                                                                                       QUERY PLAN                                                                                       
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--  Limit  (cost=1292917.46..1292917.47 rows=3 width=21) (actual time=10343.485..10433.495 rows=3 loops=1)
--    ->  Sort  (cost=1292917.46..1305198.30 rows=4912333 width=21) (actual time=10172.117..10262.126 rows=3 loops=1)
--          Sort Key: (sum(ts.quantity)) DESC
--          Sort Method: top-N heapsort  Memory: 25kB
--          ->  Finalize GroupAggregate  (cost=651511.85..1229426.48 rows=4912333 width=21) (actual time=6152.200..9803.651 rows=3933386 loops=1)
--                Group Key: m.title
--                ->  Gather Merge  (cost=651511.85..1159835.10 rows=4093610 width=21) (actual time=6152.178..8891.345 rows=3933386 loops=1)
--                      Workers Planned: 2
--                      Workers Launched: 2
--                      ->  Partial GroupAggregate  (cost=650511.82..686330.91 rows=2046805 width=21) (actual time=6112.459..7463.717 rows=1311129 loops=3)
--                            Group Key: m.title
--                            ->  Sort  (cost=650511.82..655628.84 rows=2046805 width=17) (actual time=6112.417..7101.308 rows=1665934 loops=3)
--                                  Sort Key: m.title
--                                  Sort Method: external merge  Disk: 48752kB
--                                  Worker 0:  Sort Method: external merge  Disk: 48920kB
--                                  Worker 1:  Sort Method: external merge  Disk: 49024kB
--                                  ->  Parallel Hash Join  (cost=160552.73..352005.08 rows=2046805 width=17) (actual time=1714.764..2870.048 rows=1665934 loops=3)
--                                        Hash Cond: (m.id = ts.movie_id)
--                                        ->  Parallel Seq Scan on movies m  (cost=0.00..105264.67 rows=4166667 width=17) (actual time=0.053..207.478 rows=3333333 loops=3)
--                                        ->  Parallel Hash  (cost=126971.67..126971.67 rows=2046805 width=8) (actual time=787.033..787.033 rows=1665934 loops=3)
--                                              Buckets: 131072  Batches: 128  Memory Usage: 2624kB
--                                              ->  Parallel Seq Scan on ticket_sales ts  (cost=0.00..126971.67 rows=2046805 width=8) (actual time=116.590..480.717 rows=1665934 loops=3)
--                                                    Filter: (sale_date >= (CURRENT_DATE - '7 days'::interval))
--                                                    Rows Removed by Filter: 1667400
-- Planning Time: 1.295 ms
-- JIT:
--   Functions: 55
--   Options: Inlining true, Optimization true, Expressions true, Deforming true
--   Timing: Generation 11.489 ms, Inlining 145.642 ms, Optimization 239.345 ms, Emission 136.321 ms, Total 532.796 ms
-- Execution Time: 10447.126 ms
-- (30 rows)

-- Вывод: индексы на таблицах ticket_sales и movies ускоряют запрос, но не настолько, чтобы сделать его быстрее, чем вариант с CTE.

EXPLAIN ANALYZE SELECT hs.row_number, hs.seat_number,
       CASE WHEN ts.id IS NOT NULL THEN 'occupied' ELSE 'available' END AS status
FROM hall_schema hs
LEFT JOIN ticket_sales ts ON hs.id = ts.movie_id
                          AND ts.sale_date = '2023-06-28'
WHERE ts.movie_id = 5004      
ORDER BY hs.row_number, hs.seat_number;

--                                                                   QUERY PLAN                                                                  
----------------------------------------------------------------------------------------------------------------------------------------------
--  Sort  (cost=117563.41..117563.42 rows=1 width=40) (actual time=0.069..0.071 rows=0 loops=1)
--    Sort Key: hs.row_number, hs.seat_number
--    Sort Method: quicksort  Memory: 25kB
--    ->  Nested Loop  (cost=1000.27..117563.40 rows=1 width=40) (actual time=0.036..0.038 rows=0 loops=1)
--          ->  Index Scan using hall_schema_pkey on hall_schema hs  (cost=0.28..8.29 rows=1 width=12) (actual time=0.035..0.036 rows=0 loops=1)
--                Index Cond: (id = 5004)
--          ->  Gather  (cost=1000.00..117555.10 rows=1 width=8) (never executed)
--                Workers Planned: 2
--                Workers Launched: 0
--                ->  Parallel Seq Scan on ticket_sales ts  (cost=0.00..116555.00 rows=1 width=8) (never executed)
--                      Filter: ((movie_id = 5004) AND (sale_date = '2023-06-28'::date))
--  Planning Time: 0.731 ms
--  JIT:
--    Functions: 8
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 3.224 ms, Inlining 0.000 ms, Optimization 0.000 ms, Emission 0.000 ms, Total 3.224 ms
--  Execution Time: 3.639 ms
-- (17 rows)

CREATE INDEX idx_hall_schema_id ON hall_schema (id);
CREATE INDEX idx_ticket_sales_movie_id ON ticket_sales (movie_id);
CREATE INDEX idx_ticket_sales_movie_id_sale_date ON ticket_sales (movie_id, sale_date);

--                                                                   QUERY PLAN                                                                   
------------------------------------------------------------------------------------------------------------------------------------------------
-- Sort  (cost=16.77..16.77 rows=1 width=40) (actual time=0.061..0.062 rows=0 loops=1)
--   Sort Key: hs.row_number, hs.seat_number
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop  (cost=0.71..16.76 rows=1 width=40) (actual time=0.032..0.033 rows=0 loops=1)
--         ->  Index Scan using idx_hall_schema_id on hall_schema hs  (cost=0.28..8.29 rows=1 width=12) (actual time=0.031..0.032 rows=0 loops=1)
--               Index Cond: (id = 5004)
--         ->  Index Scan using idx_ticket_sales_movie_id_sale_date on ticket_sales ts  (cost=0.43..8.46 rows=1 width=8) (never executed)
--               Index Cond: ((movie_id = 5004) AND (sale_date = '2023-06-28'::date))
-- Planning Time: 0.911 ms
-- Execution Time: 0.119 ms
-- (10 rows)

-- Вывод: индексы на таблицах ticket_sales и hall_schema ускоряют запрос, но не настолько, чтобы сделать его быстрее, чем вариант с CTE.