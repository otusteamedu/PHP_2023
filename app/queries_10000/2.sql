-- Подсчёт проданных билетов за неделю
EXPLAIN ANALYSE
SELECT COUNT(*)
FROM tickets
WHERE tickets.created_at >= CURRENT_DATE - INTERVAL '7 days';

-- Aggregate  (cost=261.40..261.41 rows=1 width=8) (actual time=2.321..2.321 rows=1 loops=1)
--   ->  Seq Scan on tickets  (cost=0.00..259.00 rows=961 width=0) (actual time=0.011..2.274 rows=961 loops=1)
--         Filter: (created_at >= (CURRENT_DATE - '7 days'::interval))
--         Rows Removed by Filter: 9039
-- Planning Time: 0.257 ms
-- Execution Time: 2.392 ms

CREATE INDEX ON tickets (created_at);

-- Aggregate  (cost=122.96..122.97 rows=1 width=8) (actual time=0.345..0.345 rows=1 loops=1)
--   ->  Bitmap Heap Scan on tickets  (cost=19.74..120.56 rows=961 width=0) (actual time=0.135..0.310 rows=961 loops=1)
--         Recheck Cond: (created_at >= (CURRENT_DATE - '7 days'::interval))
--         Heap Blocks: exact=84
--         ->  Bitmap Index Scan on tickets_created_at_idx  (cost=0.00..19.50 rows=961 width=0) (actual time=0.083..0.083 rows=961 loops=1)
--               Index Cond: (created_at >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 0.314 ms
-- Execution Time: 0.371 ms