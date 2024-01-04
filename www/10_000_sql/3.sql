EXPLAIN ANALYSE
SELECT
    m.name as "Movie name",
    s.datetime as "Datetime",
    h.name as "Hall name",
    sp.price as "Price"
FROM sessions as s
         LEFT JOIN movies m ON s.movie_id = m.id
         LEFT JOIN halls h ON s.hall_id = h.id
         LEFT JOIN session_price sp ON sp.session_id = s.id
WHERE s.datetime BETWEEN (concat(CURRENT_DATE, ' 00:00:00'))::timestamp AND (concat(CURRENT_DATE, ' 23:59:59'))::timestamp;

-- Nested Loop Left Join  (cost=8.61..37.34 rows=1 width=1318) (actual time=0.011..0.012 rows=0 loops=1)
--    Join Filter: (s.hall_id = h.id)
--    ->  Nested Loop Left Join  (cost=8.61..36.29 rows=1 width=298) (actual time=0.011..0.012 rows=0 loops=1)
--          ->  Hash Right Join  (cost=8.33..27.99 rows=1 width=24) (actual time=0.011..0.012 rows=0 loops=1)
--                Hash Cond: (sp.session_id = s.id)
--                ->  Seq Scan on session_price sp  (cost=0.00..17.02 rows=1002 width=12) (never executed)
--                ->  Hash  (cost=8.31..8.31 rows=1 width=20) (actual time=0.008..0.008 rows=0 loops=1)
--                      Buckets: 1024  Batches: 1  Memory Usage: 8kB
--                      ->  Index Scan using idx_sessions_datetime on sessions s  (cost=0.29..8.31 rows=1 width=2
-- 0) (actual time=0.008..0.008 rows=0 loops=1)
--                            Index Cond: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without ti
-- me zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))
--          ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=282) (never executed)
--                Index Cond: (id = s.movie_id)
--    ->  Seq Scan on halls h  (cost=0.00..1.02 rows=2 width=1028) (never executed)
--  Planning Time: 0.370 ms
--  Execution Time: 0.034 ms

-- create index --
create index idx_sessions_datetime on sessions(datetime);


-- Nested Loop Left Join  (cost=8.61..37.34 rows=1 width=1318) (actual time=0.009..0.010 rows=0 loops=1)
--    Join Filter: (s.hall_id = h.id)
--    ->  Nested Loop Left Join  (cost=8.61..36.29 rows=1 width=298) (actual time=0.009..0.010 rows=0 loops=1)
--          ->  Hash Right Join  (cost=8.33..27.99 rows=1 width=24) (actual time=0.009..0.010 rows=0 loops=1)
--                Hash Cond: (sp.session_id = s.id)
--                ->  Seq Scan on session_price sp  (cost=0.00..17.02 rows=1002 width=12) (never executed)
--                ->  Hash  (cost=8.31..8.31 rows=1 width=20) (actual time=0.006..0.007 rows=0 loops=1)
--                      Buckets: 1024  Batches: 1  Memory Usage: 8kB
--                      ->  Index Scan using idx_sessions_datetime on sessions s  (cost=0.29..8.31 rows=1 width=2
-- 0) (actual time=0.006..0.006 rows=0 loops=1)
--                            Index Cond: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without ti
-- me zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))
--          ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=282) (never executed)
--                Index Cond: (id = s.movie_id)
--    ->  Seq Scan on halls h  (cost=0.00..1.02 rows=2 width=1028) (never executed)
--  Planning Time: 0.270 ms
--  Execution Time: 0.032 ms