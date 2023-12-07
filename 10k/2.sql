--Подсчёт проданных билетов за неделю
EXPLAIN ANALYSE
SELECT count(tickets.id)
FROM tickets
         LEFT JOIN showtime ON tickets.showtime_id = showtime.id
WHERE showtime.start_time BETWEEN date_trunc('week', now())
          AND (date_trunc('week', now()) + '6 days 23 hours 59 minutes'::interval);

-- Aggregate  (cost=227.26..227.27 rows=1 width=8) (actual time=3.010..3.012 rows=1 loops=1)
--   ->  Hash Join  (cost=49.96..227.15 rows=43 width=4) (actual time=0.145..2.922 rows=1147 loops=1)
--         Hash Cond: (tickets.showtime_id = showtime.id)
--         ->  Seq Scan on tickets  (cost=0.00..153.60 rows=8960 width=8) (actual time=0.015..1.299 rows=10000 loops=1)
--         ->  Hash  (cost=49.88..49.88 rows=7 width=4) (actual time=0.112..0.113 rows=11 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on showtime  (cost=0.00..49.88 rows=7 width=4) (actual time=0.015..0.082 rows=11 loops=1)
-- "                    Filter: ((start_time >= date_trunc('week'::text, now())) AND (start_time <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
--                     Rows Removed by Filter: 89
-- Planning Time: 0.297 ms
-- Execution Time: 3.158 ms


create index idx_datetime on showtime(start_time);

-- Aggregate  (cost=198.26..198.27 rows=1 width=8) (actual time=1.527..1.530 rows=1 loops=1)
--   ->  Hash Join  (cost=3.90..195.26 rows=1200 width=4) (actual time=0.072..1.475 rows=1147 loops=1)
--         Hash Cond: (tickets.showtime_id = showtime.id)
--         ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.008..0.636 rows=10000 loops=1)
--         ->  Hash  (cost=3.75..3.75 rows=12 width=4) (actual time=0.049..0.050 rows=11 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 9kB
--               ->  Seq Scan on showtime  (cost=0.00..3.75 rows=12 width=4) (actual time=0.009..0.037 rows=11 loops=1)
-- "                    Filter: ((start_time >= date_trunc('week'::text, now())) AND (start_time <= (date_trunc('week'::text, now()) + '6 days 23:59:00'::interval)))"
--                     Rows Removed by Filter: 89
-- Planning Time: 2.306 ms
-- Execution Time: 1.578 ms
