--Подсчёт проданных билетов за неделю
EXPLAIN ANALYSE
SELECT count(tickets.id)
FROM tickets
         LEFT JOIN showtime ON tickets.showtime_id = showtime.id
WHERE showtime.start_time BETWEEN date_trunc('week', now())
          AND (date_trunc('week', now()) + '6 days 23 hours 59 minutes'::interval);

-- Finalize Aggregate  (cost=12799.38..12799.39 rows=1 width=8) (actual time=131.490..138.716 rows=1 loops=1)
--   ->  Gather  (cost=12799.16..12799.37 rows=2 width=8) (actual time=131.312..138.710 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=11799.16..11799.17 rows=1 width=8) (actual time=111.298..111.300 rows=1 loops=3)
--               ->  Hash Join  (cost=37.02..11672.08 rows=50833 width=4) (actual time=0.737..109.139 rows=39892 loops=3)
--                     Hash Cond: (tickets.showtime_id = showtime.id)
--                     ->  Parallel Seq Scan on tickets  (cost=0.00..10536.67 rows=416667 width=8) (actual time=0.019..43.473 rows=333333 loops=3)
--                     ->  Hash  (cost=35.50..35.50 rows=122 width=4) (actual time=0.561..0.562 rows=120 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 13kB
--                           ->  Seq Scan on showtime  (cost=0.00..35.50 rows=122 width=4) (actual time=0.090..0.533 rows=120 loops=3)
-- "                                Filter: ((start_time >= date_trunc('week'::text, now())) AND (start_time <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
--                                 Rows Removed by Filter: 880
-- Planning Time: 4.201 ms
-- Execution Time: 138.893 ms

create index idx_datetime on showtime(start_time);

-- Finalize Aggregate  (cost=12780.77..12780.78 rows=1 width=8) (actual time=65.486..68.371 rows=1 loops=1)
--   ->  Gather  (cost=12780.56..12780.77 rows=2 width=8) (actual time=65.313..68.364 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=11780.56..11780.57 rows=1 width=8) (actual time=49.356..49.358 rows=1 loops=3)
--               ->  Hash Join  (cost=18.42..11653.47 rows=50833 width=4) (actual time=0.364..47.607 rows=39892 loops=3)
--                     Hash Cond: (tickets.showtime_id = showtime.id)
--                     ->  Parallel Seq Scan on tickets  (cost=0.00..10536.67 rows=416667 width=8) (actual time=0.010..20.329 rows=333333 loops=3)
--                     ->  Hash  (cost=16.89..16.89 rows=122 width=4) (actual time=0.253..0.253 rows=120 loops=3)
--                           Buckets: 1024  Batches: 1  Memory Usage: 13kB
--                           ->  Bitmap Heap Scan on showtime  (cost=5.54..16.89 rows=122 width=4) (actual time=0.196..0.227 rows=120 loops=3)
-- "                                Recheck Cond: ((start_time >= date_trunc('week'::text, now())) AND (start_time <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
--                                 Heap Blocks: exact=8
--                                 ->  Bitmap Index Scan on idx_datetime  (cost=0.00..5.51 rows=122 width=0) (actual time=0.047..0.047 rows=120 loops=3)
-- "                                      Index Cond: ((start_time >= date_trunc('week'::text, now())) AND (start_time <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
-- Planning Time: 0.751 ms
-- Execution Time: 68.509 ms
