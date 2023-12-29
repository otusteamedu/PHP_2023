-- Подсчёт проданных билетов за неделю

EXPLAIN ANALYZE
SELECT count(*)
FROM tickets
WHERE
    status = 1
    AND (purchased_at BETWEEN (CURRENT_DATE - INTERVAL '7 day') and CURRENT_DATE)
;

-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Aggregate  (cost=735.35..735.36 rows=1 width=8) (actual time=5.998..6.000 rows=1 loops=1)
--    ->  Seq Scan on tickets  (cost=0.00..734.80 rows=218 width=0) (actual time=0.200..5.954 rows=349 loops=1)
--          Filter: ((status = 1) AND (purchased_at <= CURRENT_DATE) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)))
--          Rows Removed by Filter: 9651
--  Planning Time: 0.126 ms
--  Execution Time: 6.038 ms
-- (6 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Aggregate  (cost=188518.77..188518.78 rows=1 width=8) (actual time=1404.224..1412.186 rows=1 loops=1)
--    ->  Gather  (cost=1000.00..188518.77 rows=1 width=0) (actual time=1403.239..1412.125 rows=253 loops=1)
--          Workers Planned: 2
--          Workers Launched: 2
--          ->  Parallel Seq Scan on tickets  (cost=0.00..187518.67 rows=1 width=0) (actual time=1369.648..1369.705 rows=84 loops=3)
--                Filter: ((status = 1) AND (purchased_at <= CURRENT_DATE) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)))
--                Rows Removed by Filter: 3333249
--  Planning Time: 0.346 ms
--  JIT:
--    Functions: 11
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 3.067 ms, Inlining 0.000 ms, Optimization 1.747 ms, Emission 22.771 ms, Total 27.585 ms
--  Execution Time: 1413.302 ms
-- (13 rows)


CREATE INDEX ON tickets USING btree(status, purchased_at);

-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Aggregate  (cost=157.37..157.38 rows=1 width=8) (actual time=0.227..0.228 rows=1 loops=1)
--    ->  Bitmap Heap Scan on tickets  (cost=5.52..157.13 rows=96 width=0) (actual time=0.054..0.204 rows=349 loops=1)
--          Recheck Cond: ((status = 1) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)) AND (purchased_at <= CURRENT_DATE))
--          Heap Blocks: exact=83
--          ->  Bitmap Index Scan on tickets_status_purchased_at_idx  (cost=0.00..5.49 rows=96 width=0) (actual time=0.037..0.037 rows=349 loops=1)
--                Index Cond: ((status = 1) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)) AND (purchased_at <= CURRENT_DATE))
--  Planning Time: 0.097 ms
--  Execution Time: 0.329 ms
-- (8 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Aggregate  (cost=8.47..8.48 rows=1 width=8) (actual time=0.109..0.110 rows=1 loops=1)
--    ->  Index Only Scan using tickets_status_purchased_at on tickets  (cost=0.44..8.46 rows=1 width=0) (actual time=0.049..0.091 rows=253 loops=1)
--          Index Cond: ((status = 1) AND (purchased_at >= (CURRENT_DATE - '7 days'::interval)) AND (purchased_at <= CURRENT_DATE))
--          Heap Fetches: 253
--  Planning Time: 0.099 ms
--  Execution Time: 0.153 ms
-- (6 rows)

