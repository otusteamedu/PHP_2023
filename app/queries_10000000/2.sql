-- Подсчёт проданных билетов за неделю
EXPLAIN ANALYSE
SELECT COUNT(*)
FROM tickets
WHERE tickets.created_at >= CURRENT_DATE - INTERVAL '7 days';

-- Finalize Aggregate  (cost=158059.46..158059.47 rows=1 width=8) (actual time=2237.419..2237.419 rows=1 loops=1)
--   ->  Gather  (cost=158059.24..158059.45 rows=2 width=8) (actual time=2237.136..2240.851 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=157059.24..157059.25 rows=1 width=8) (actual time=2218.703..2218.703 rows=1 loops=3)
--               ->  Parallel Seq Scan on tickets  (cost=0.00..156251.25 rows=323197 width=0) (actual time=0.131..2201.733 rows=266002 loops=3)
--                     Filter: (created_at >= (CURRENT_DATE - '7 days'::interval))
--                     Rows Removed by Filter: 3067331
-- Planning Time: 1.246 ms
-- Execution Time: 2240.975 ms

CREATE INDEX ON tickets (created_at);

-- Finalize Aggregate  (cost=146142.93..146142.94 rows=1 width=8) (actual time=631.495..631.495 rows=1 loops=1)
--   ->  Gather  (cost=146142.72..146142.93 rows=2 width=8) (actual time=630.669..637.255 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=145142.72..145142.73 rows=1 width=8) (actual time=607.569..607.569 rows=1 loops=3)
--               ->  Parallel Bitmap Heap Scan on tickets  (cost=14531.86..144334.73 rows=323195 width=0) (actual time=47.188..595.820 rows=266002 loops=3)
--                     Recheck Cond: (created_at >= (CURRENT_DATE - '7 days'::interval))
--                     Rows Removed by Index Recheck: 1217056
--                     Heap Blocks: exact=16984 lossy=11340
--                     ->  Bitmap Index Scan on tickets_created_at_idx  (cost=0.00..14337.94 rows=775667 width=0) (actual time=63.665..63.665 rows=798007 loops=1)
--                           Index Cond: (created_at >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 0.327 ms
-- Execution Time: 637.299 ms