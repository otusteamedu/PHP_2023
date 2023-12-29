-- Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

EXPLAIN ANALYZE
SELECT
s.row,
s.place,
CASE WHEN t.status = 1 THEN 1 ELSE 0 END AS is_purchased
FROM seats s
    LEFT JOIN tickets t ON (s.id = t.seat_id AND t.session_id = 1)
ORDER BY is_purchased, s.row, s.place;


-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Sort  (cost=432.48..437.10 rows=1850 width=12) (actual time=1.149..1.157 rows=100 loops=1)
--    Sort Key: (CASE WHEN (t.status = 1) THEN 1 ELSE 0 END), s."row", s.place
--    Sort Method: quicksort  Memory: 29kB
--    ->  Hash Left Join  (cost=292.01..332.08 rows=1850 width=12) (actual time=1.059..1.091 rows=100 loops=1)
--          Hash Cond: (s.id = t.seat_id)
--          ->  Seq Scan on seats s  (cost=0.00..28.50 rows=1850 width=12) (actual time=0.008..0.017 rows=100 loops=1)
--          ->  Hash  (cost=292.00..292.00 rows=1 width=8) (actual time=1.034..1.034 rows=1 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on tickets t  (cost=0.00..292.00 rows=1 width=8) (actual time=0.529..1.020 rows=1 loops=1)
--                      Filter: (session_id = 1)
--                      Rows Removed by Filter: 9999
--  Planning Time: 0.497 ms
--  Execution Time: 1.233 ms
-- (13 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Sort  (cost=136584.03..136588.66 rows=1850 width=12) (actual time=539.605..545.490 rows=126 loops=1)
--    Sort Key: (CASE WHEN (t.status = 1) THEN 1 ELSE 0 END), s."row", s.place
--    Sort Method: quicksort  Memory: 30kB
--    ->  Hash Right Join  (cost=1051.62..136483.64 rows=1850 width=12) (actual time=33.279..545.369 rows=126 loops=1)
--          Hash Cond: (t.seat_id = s.id)
--          ->  Gather  (cost=1000.00..136427.13 rows=98 width=8) (actual time=16.963..528.933 rows=92 loops=1)
--                Workers Planned: 2
--                Workers Launched: 2
--                ->  Parallel Seq Scan on tickets t  (cost=0.00..135417.33 rows=41 width=8) (actual time=19.512..479.471 rows=31 loops=3)
--                      Filter: (session_id = 1)
--                      Rows Removed by Filter: 3333303
--          ->  Hash  (cost=28.50..28.50 rows=1850 width=12) (actual time=16.211..16.213 rows=100 loops=1)
--                Buckets: 2048  Batches: 1  Memory Usage: 21kB
--                ->  Seq Scan on seats s  (cost=0.00..28.50 rows=1850 width=12) (actual time=16.150..16.165 rows=100 loops=1)
--  Planning Time: 0.348 ms
--  JIT:
--    Functions: 20
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 2.346 ms, Inlining 0.000 ms, Optimization 2.876 ms, Emission 31.709 ms, Total 36.931 ms
--  Execution Time: 546.342 ms
-- (20 rows)

CREATE INDEX ON tickets(session_id);

-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Sort  (cost=148.78..153.41 rows=1850 width=12) (actual time=0.204..0.215 rows=100 loops=1)
--    Sort Key: (CASE WHEN (t.status = 1) THEN 1 ELSE 0 END), s."row", s.place
--    Sort Method: quicksort  Memory: 29kB
--    ->  Hash Left Join  (cost=8.31..48.39 rows=1850 width=12) (actual time=0.088..0.128 rows=100 loops=1)
--          Hash Cond: (s.id = t.seat_id)
--          ->  Seq Scan on seats s  (cost=0.00..28.50 rows=1850 width=12) (actual time=0.009..0.020 rows=100 loops=1)
--          ->  Hash  (cost=8.30..8.30 rows=1 width=8) (actual time=0.053..0.054 rows=1 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Index Scan using tickets_session_id_idx on tickets t  (cost=0.29..8.30 rows=1 width=8) (actual time=0.036..0.038 rows=1 loops=1)
--                      Index Cond: (session_id = 1)
--  Planning Time: 0.359 ms
--  Execution Time: 0.307 ms
-- (12 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Sort  (cost=545.24..549.86 rows=1850 width=12) (actual time=0.419..0.427 rows=126 loops=1)
--    Sort Key: (CASE WHEN (t.status = 1) THEN 1 ELSE 0 END), s."row", s.place
--    Sort Method: quicksort  Memory: 30kB
--    ->  Hash Right Join  (cost=56.82..444.84 rows=1850 width=12) (actual time=0.096..0.233 rows=126 loops=1)
--          Hash Cond: (t.seat_id = s.id)
--          ->  Bitmap Heap Scan on tickets t  (cost=5.19..388.34 rows=98 width=8) (actual time=0.036..0.140 rows=92 loops=1)
--                Recheck Cond: (session_id = 1)
--                Heap Blocks: exact=92
--                ->  Bitmap Index Scan on tickets_session_id_idx  (cost=0.00..5.17 rows=98 width=0) (actual time=0.021..0.022 rows=92 loops=1)
--                      Index Cond: (session_id = 1)
--          ->  Hash  (cost=28.50..28.50 rows=1850 width=12) (actual time=0.040..0.040 rows=100 loops=1)
--                Buckets: 2048  Batches: 1  Memory Usage: 21kB
--                ->  Seq Scan on seats s  (cost=0.00..28.50 rows=1850 width=12) (actual time=0.007..0.016 rows=100 loops=1)
--  Planning Time: 0.521 ms
--  Execution Time: 0.545 ms
-- (15 rows)
