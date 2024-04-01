-- Подсчёт проданных билетов за неделю
EXPLAIN ANALYSE
SELECT COUNT(*)
FROM orders
         JOIN tickets ON orders.ticket_id = tickets.id
         JOIN sessions ON tickets.sessions_id = sessions.id
WHERE sessions.start_time >= CURRENT_DATE - INTERVAL '7 days';

-- Finalize Aggregate  (cost=605361.31..605361.32 rows=1 width=8) (actual time=6489.982..6489.982 rows=1 loops=1)
--   ->  Gather  (cost=605361.09..605361.30 rows=2 width=8) (actual time=6488.178..7093.049 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=604361.09..604361.10 rows=1 width=8) (actual time=6464.917..6464.917 rows=1 loops=3)
--               ->  Parallel Hash Join  (cost=378691.80..593944.57 rows=4166608 width=0) (actual time=5237.646..6338.602 rows=3333333 loops=3)
--                     Hash Cond: (tickets.sessions_id = sessions.id)
--                     ->  Parallel Hash Join  (cost=173719.79..329206.22 rows=4166608 width=4) (actual time=1995.992..3167.907 rows=3333333 loops=3)
--                           Hash Cond: (orders.ticket_id = tickets.id)
--                           ->  Parallel Seq Scan on orders  (cost=0.00..95721.08 rows=4166608 width=4) (actual time=0.017..378.716 rows=3333333 loops=3)
--                           ->  Parallel Hash  (cost=105361.13..105361.13 rows=4166613 width=8) (actual time=1020.242..1020.242 rows=3333333 loops=3)
--                                 Buckets: 131072  Batches: 256  Memory Usage: 2592kB
--                                 ->  Parallel Seq Scan on tickets  (cost=0.00..105361.13 rows=4166613 width=8) (actual time=0.057..411.053 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=136611.67..136611.67 rows=4166667 width=4) (actual time=1506.681..1506.681 rows=3333333 loops=3)
--                           Buckets: 131072  Batches: 256  Memory Usage: 2592kB
--                           ->  Parallel Seq Scan on sessions  (cost=0.00..136611.67 rows=4166667 width=4) (actual time=0.013..939.457 rows=3333333 loops=3)
--                                 Filter: (start_time >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 0.370 ms
-- Execution Time: 7093.166 ms

CREATE INDEX ON orders (ticket_id);
CREATE INDEX ON tickets (sessions_id);
CREATE INDEX ON sessions (start_time);

-- Finalize Aggregate  (cost=605369.56..605369.57 rows=1 width=8) (actual time=6270.773..6270.773 rows=1 loops=1)
--   ->  Gather  (cost=605369.34..605369.55 rows=2 width=8) (actual time=6268.728..6857.358 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=604369.34..604369.35 rows=1 width=8) (actual time=6245.802..6245.803 rows=1 loops=3)
--               ->  Parallel Hash Join  (cost=378694.01..593952.68 rows=4166667 width=0) (actual time=5050.636..6115.497 rows=3333333 loops=3)
--                     Hash Cond: (tickets.sessions_id = sessions.id)
--                     ->  Parallel Hash Join  (cost=173722.00..329212.17 rows=4166667 width=4) (actual time=1880.932..3009.511 rows=3333333 loops=3)
--                           Hash Cond: (orders.ticket_id = tickets.id)
--                           ->  Parallel Seq Scan on orders  (cost=0.00..95721.67 rows=4166667 width=4) (actual time=0.018..351.346 rows=3333333 loops=3)
--                           ->  Parallel Hash  (cost=105361.67..105361.67 rows=4166667 width=8) (actual time=982.130..982.130 rows=3333333 loops=3)
--                                 Buckets: 131072  Batches: 256  Memory Usage: 2592kB
--                                 ->  Parallel Seq Scan on tickets  (cost=0.00..105361.67 rows=4166667 width=8) (actual time=0.058..402.852 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=136611.67..136611.67 rows=4166667 width=4) (actual time=1490.314..1490.314 rows=3333333 loops=3)
--                           Buckets: 131072  Batches: 256  Memory Usage: 2592kB
--                           ->  Parallel Seq Scan on sessions  (cost=0.00..136611.67 rows=4166667 width=4) (actual time=0.035..938.018 rows=3333333 loops=3)
--                                 Filter: (start_time >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 0.936 ms
-- Execution Time: 6857.569 ms