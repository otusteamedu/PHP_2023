-- Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

EXPLAIN ANALYZE
SELECT
    MIN(t.price),
    MAX(t.price)
FROM tickets t
WHERE
    t.session_id = 1
;

-----------------------------------------100000------------------------------------------------------
-- Aggregate  (cost=292.00..292.01 rows=1 width=16) (actual time=1.322..1.323 rows=1 loops=1)
--    ->  Seq Scan on tickets t  (cost=0.00..292.00 rows=1 width=8) (actual time=0.742..1.313 rows=1 loops=1)
--          Filter: (session_id = 1)
--          Rows Removed by Filter: 9999
--  Planning Time: 0.111 ms
--  Execution Time: 1.606 ms
-- (6 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Finalize Aggregate  (cost=136417.76..136417.77 rows=1 width=16) (actual time=811.161..812.379 rows=1 loops=1)
--    ->  Gather  (cost=136417.54..136417.75 rows=2 width=16) (actual time=800.683..812.322 rows=3 loops=1)
--          Workers Planned: 2
--          Workers Launched: 2
--          ->  Partial Aggregate  (cost=135417.54..135417.55 rows=1 width=16) (actual time=552.710..552.712 rows=1 loops=3)
--                ->  Parallel Seq Scan on tickets t  (cost=0.00..135417.33 rows=41 width=8) (actual time=32.935..552.571 rows=31 loops=3)
--                      Filter: (session_id = 1)
--                      Rows Removed by Filter: 3333303
--  Planning Time: 0.290 ms
--  JIT:
--    Functions: 17
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 4.608 ms, Inlining 0.000 ms, Optimization 2.057 ms, Emission 35.660 ms, Total 42.324 ms
--  Execution Time: 814.685 ms
-- (14 rows)


CREATE INDEX ON tickets(session_id);


-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Aggregate  (cost=8.31..8.32 rows=1 width=16) (actual time=0.041..0.042 rows=1 loops=1)
--    ->  Index Scan using tickets_session_id_idx on tickets t  (cost=0.29..8.30 rows=1 width=8) (actual time=0.033..0.034 rows=1 loops=1)
--          Index Cond: (session_id = 1)
--  Planning Time: 1.157 ms
--  Execution Time: 0.089 ms
-- (5 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Aggregate  (cost=388.83..388.84 rows=1 width=16) (actual time=0.199..0.200 rows=1 loops=1)
--    ->  Bitmap Heap Scan on tickets t  (cost=5.19..388.34 rows=98 width=8) (actual time=0.050..0.183 rows=92 loops=1)
--          Recheck Cond: (session_id = 1)
--          Heap Blocks: exact=92
--          ->  Bitmap Index Scan on tickets_session_id_idx  (cost=0.00..5.17 rows=98 width=0) (actual time=0.033..0.033 rows=92 loops=1)
--                Index Cond: (session_id = 1)
--  Planning Time: 0.129 ms
--  Execution Time: 0.291 ms
-- (8 rows)

