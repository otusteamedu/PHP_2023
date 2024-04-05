EXPLAIN ANALYSE
SELECT MIN(price), MAX(price)
FROM tickets
WHERE sessions_id = 1;

-- Aggregate  (cost=136417.44..136417.45 rows=1 width=64) (actual time=396.274..396.274 rows=1 loops=1)
--   ->  Gather  (cost=1000.00..136417.43 rows=1 width=5) (actual time=395.998..399.941 rows=1 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Parallel Seq Scan on tickets  (cost=0.00..135417.33 rows=1 width=5) (actual time=375.664..375.665 rows=0 loops=3)
--               Filter: (sessions_id = 1)
--               Rows Removed by Filter: 3333333
-- Planning Time: 12.145 ms
-- Execution Time: 400.065 ms

CREATE INDEX ON tickets (sessions_id);

-- Aggregate  (cost=8.46..8.47 rows=1 width=64) (actual time=0.045..0.045 rows=1 loops=1)
--   ->  Index Scan using tickets_sessions_id_idx on tickets  (cost=0.43..8.45 rows=1 width=5) (actual time=0.040..0.040 rows=1 loops=1)
--         Index Cond: (sessions_id = 1)
-- Planning Time: 0.291 ms
-- Execution Time: 0.072 ms