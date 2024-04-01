EXPLAIN ANALYSE
SELECT MIN(price), MAX(price)
FROM tickets
WHERE sessions_id = 1;

-- Aggregate  (cost=189.00..189.01 rows=1 width=64) (actual time=0.636..0.636 rows=1 loops=1)
--   ->  Seq Scan on tickets  (cost=0.00..189.00 rows=1 width=5) (actual time=0.632..0.632 rows=1 loops=1)
--         Filter: (sessions_id = 1)
--         Rows Removed by Filter: 9999
-- Planning Time: 0.113 ms
-- Execution Time: 0.655 ms

CREATE INDEX ON tickets (sessions_id);

-- Aggregate  (cost=8.31..8.32 rows=1 width=64) (actual time=0.021..0.021 rows=1 loops=1)
--   ->  Index Scan using tickets_sessions_id_idx on tickets  (cost=0.29..8.30 rows=1 width=5) (actual time=0.017..0.017 rows=1 loops=1)
--         Index Cond: (sessions_id = 1)
-- Planning Time: 0.316 ms
-- Execution Time: 0.038 ms