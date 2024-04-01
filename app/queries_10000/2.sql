-- Подсчёт проданных билетов за неделю
EXPLAIN ANALYSE
SELECT COUNT(*)
FROM orders
         JOIN tickets ON orders.ticket_id = tickets.id
         JOIN sessions ON tickets.sessions_id = sessions.id
WHERE sessions.start_time >= CURRENT_DATE - INTERVAL '7 days';

-- Aggregate  (cost=885.52..885.53 rows=1 width=8) (actual time=9.173..9.173 rows=1 loops=1)
--   ->  Hash Join  (cost=653.00..860.52 rows=10000 width=0) (actual time=5.101..8.830 rows=10000 loops=1)
--         Hash Cond: (tickets.sessions_id = sessions.id)
--         ->  Hash Join  (cost=289.00..470.26 rows=10000 width=4) (actual time=1.871..4.228 rows=10000 loops=1)
--               Hash Cond: (orders.ticket_id = tickets.id)
--               ->  Seq Scan on orders  (cost=0.00..155.00 rows=10000 width=4) (actual time=0.009..0.730 rows=10000 loops=1)
--               ->  Hash  (cost=164.00..164.00 rows=10000 width=8) (actual time=1.823..1.823 rows=10000 loops=1)
--                     Buckets: 16384  Batches: 1  Memory Usage: 519kB
--                     ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.005..0.924 rows=10000 loops=1)
--         ->  Hash  (cost=239.00..239.00 rows=10000 width=4) (actual time=3.188..3.188 rows=10000 loops=1)
--               Buckets: 16384  Batches: 1  Memory Usage: 480kB
--               ->  Seq Scan on sessions  (cost=0.00..239.00 rows=10000 width=4) (actual time=0.009..2.264 rows=10000 loops=1)
--                     Filter: (start_time >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 0.480 ms
-- Execution Time: 9.395 ms

CREATE INDEX ON orders (ticket_id);
CREATE INDEX ON tickets (sessions_id);
CREATE INDEX ON sessions (start_time);

-- Aggregate  (cost=885.52..885.53 rows=1 width=8) (actual time=9.036..9.036 rows=1 loops=1)
--   ->  Hash Join  (cost=653.00..860.52 rows=10000 width=0) (actual time=4.990..8.677 rows=10000 loops=1)
--         Hash Cond: (tickets.sessions_id = sessions.id)
--         ->  Hash Join  (cost=289.00..470.26 rows=10000 width=4) (actual time=1.758..4.043 rows=10000 loops=1)
--               Hash Cond: (orders.ticket_id = tickets.id)
--               ->  Seq Scan on orders  (cost=0.00..155.00 rows=10000 width=4) (actual time=0.008..0.617 rows=10000 loops=1)
--               ->  Hash  (cost=164.00..164.00 rows=10000 width=8) (actual time=1.715..1.715 rows=10000 loops=1)
--                     Buckets: 16384  Batches: 1  Memory Usage: 519kB
--                     ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.005..0.799 rows=10000 loops=1)
--         ->  Hash  (cost=239.00..239.00 rows=10000 width=4) (actual time=3.193..3.193 rows=10000 loops=1)
--               Buckets: 16384  Batches: 1  Memory Usage: 480kB
--               ->  Seq Scan on sessions  (cost=0.00..239.00 rows=10000 width=4) (actual time=0.009..2.260 rows=10000 loops=1)
--                     Filter: (start_time >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 0.836 ms
-- Execution Time: 9.180 ms