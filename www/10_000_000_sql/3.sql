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

-- Hash Left Join  (cost=6203.85..8320.11 rows=1589 width=1318) (actual time=75.150..82.034 rows=2743 loops=1)
--    Hash Cond: (s.hall_id = h.id)
--    ->  Merge Right Join  (cost=6202.80..8313.13 rows=1589 width=298) (actual time=75.108..81.592 rows=2743 loo
-- ps=1)
--          Merge Cond: (m.id = s.movie_id)
--          ->  Index Scan using movies_pkey on movies m  (cost=0.29..7417.29 rows=110000 width=282) (actual time
-- =0.005..4.490 rows=29987 loops=1)
--          ->  Sort  (cost=6202.51..6206.48 rows=1589 width=24) (actual time=75.094..75.224 rows=2743 loops=1)
--                Sort Key: s.movie_id
--                Sort Method: quicksort  Memory: 217kB
--                ->  Hash Right Join  (cost=4198.86..6118.02 rows=1589 width=24) (actual time=60.476..74.615 row
-- s=2743 loops=1)
--                      Hash Cond: (sp.session_id = s.id)
--                      ->  Seq Scan on session_price sp  (cost=0.00..1654.02 rows=101002 width=12) (actual time=
-- 0.008..5.604 rows=101002 loops=1)
--                      ->  Hash  (cost=4179.00..4179.00 rows=1589 width=20) (actual time=60.434..60.434 rows=158
-- 1 loops=1)
--                            Buckets: 2048  Batches: 1  Memory Usage: 97kB
--                            ->  Seq Scan on sessions s  (cost=0.00..4179.00 rows=1589 width=20) (actual time=0.
-- 455..60.209 rows=1581 loops=1)
--                                  Filter: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without
-- time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))
--                                  Rows Removed by Filter: 99419
--    ->  Hash  (cost=1.02..1.02 rows=2 width=1028) (actual time=0.012..0.012 rows=12 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 12kB
--          ->  Seq Scan on halls h  (cost=0.00..1.02 rows=2 width=1028) (actual time=0.008..0.009 rows=12 loops=
-- 1)
--  Planning Time: 0.288 ms
--  Execution Time: 82.131 ms

-- create index --
create index idx_sessions_datetime on sessions(datetime);

-- Hash Left Join  (cost=2761.06..4877.33 rows=1589 width=1318) (actual time=13.336..20.186 rows=2743 loops=1)
--    Hash Cond: (s.hall_id = h.id)
--    ->  Merge Right Join  (cost=2760.02..4870.34 rows=1589 width=298) (actual time=13.325..19.792 rows=2743 loo
-- ps=1)
--          Merge Cond: (m.id = s.movie_id)
--          ->  Index Scan using movies_pkey on movies m  (cost=0.29..7417.29 rows=110000 width=282) (actual time
-- =0.005..4.396 rows=29987 loops=1)
--          ->  Sort  (cost=2759.72..2763.70 rows=1589 width=24) (actual time=13.312..13.493 rows=2743 loops=1)
--                Sort Key: s.movie_id
--                Sort Method: quicksort  Memory: 217kB
--                ->  Hash Right Join  (cost=756.08..2675.24 rows=1589 width=24) (actual time=1.051..12.848 rows=
-- 2743 loops=1)
--                      Hash Cond: (sp.session_id = s.id)
--                      ->  Seq Scan on session_price sp  (cost=0.00..1654.02 rows=101002 width=12) (actual time=
-- 0.004..4.450 rows=101002 loops=1)
--                      ->  Hash  (cost=736.21..736.21 rows=1589 width=20) (actual time=1.010..1.010 rows=1581 lo
-- ops=1)
--                            Buckets: 2048  Batches: 1  Memory Usage: 97kB
--                            ->  Bitmap Heap Scan on sessions s  (cost=36.60..736.21 rows=1589 width=20) (actual
--  time=0.202..0.830 rows=1581 loops=1)
--                                  Recheck Cond: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp wi
-- thout time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))
--                                  Heap Blocks: exact=592
--                                  ->  Bitmap Index Scan on idx_sessions_datetime  (cost=0.00..36.20 rows=1589 w
-- idth=0) (actual time=0.151..0.151 rows=1581 loops=1)
--                                        Index Cond: ((datetime >= (concat(CURRENT_DATE, ' 00:00:00'))::timestam
-- p without time zone) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))
--    ->  Hash  (cost=1.02..1.02 rows=2 width=1028) (actual time=0.007..0.007 rows=12 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 12kB
--          ->  Seq Scan on halls h  (cost=0.00..1.02 rows=2 width=1028) (actual time=0.004..0.005 rows=12 loops=
-- 1)
--  Planning Time: 0.377 ms
--  Execution Time: 20.337 ms