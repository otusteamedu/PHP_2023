EXPLAIN ANALYSE
SELECT MIN(price), MAX(price)
FROM tickets
WHERE sessions_id = 1;

-- Aggregate  (cost=116778.44..116778.45 rows=1 width=64) (actual time=382.824..382.824 rows=1 loops=1)
--   ->  Gather  (cost=1000.00..116778.43 rows=1 width=5) (actual time=382.534..386.567 rows=1 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Parallel Seq Scan on tickets  (cost=0.00..115778.33 rows=1 width=5) (actual time=361.166..361.166 rows=0 loops=3)
--               Filter: (sessions_id = 1)
--               Rows Removed by Filter: 3333333
-- Planning Time: 0.294 ms
-- Execution Time: 386.606 ms

CREATE INDEX ON tickets (sessions_id);

-- Aggregate  (cost=8.46..8.47 rows=1 width=64) (actual time=0.040..0.041 rows=1 loops=1)
--   ->  Index Scan using tickets_sessions_id_idx on tickets  (cost=0.43..8.45 rows=1 width=5) (actual time=0.036..0.037 rows=1 loops=1)
--         Index Cond: (sessions_id = 1)
-- Planning Time: 0.278 ms
-- Execution Time: 0.057 ms