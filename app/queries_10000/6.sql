EXPLAIN ANALYSE
SELECT MIN(price), MAX(price)
FROM tickets
WHERE sessions_id = 1;

-- Aggregate  (cost=209.00..209.01 rows=1 width=64) (actual time=0.674..0.674 rows=1 loops=1)
--   ->  Seq Scan on tickets  (cost=0.00..209.00 rows=1 width=5) (actual time=0.671..0.671 rows=1 loops=1)
--         Filter: (sessions_id = 1)
--         Rows Removed by Filter: 9999
-- Planning Time: 11.996 ms
-- Execution Time: 0.696 ms

CREATE INDEX ON tickets (sessions_id);

-- Aggregate  (cost=8.31..8.32 rows=1 width=64) (actual time=0.029..0.029 rows=1 loops=1)
--   ->  Index Scan using tickets_sessions_id_idx on tickets  (cost=0.29..8.30 rows=1 width=5) (actual time=0.025..0.026 rows=1 loops=1)
--         Index Cond: (sessions_id = 1)
-- Planning Time: 0.252 ms
-- Execution Time: 0.044 ms