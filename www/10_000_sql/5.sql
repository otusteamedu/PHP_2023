EXPLAIN ANALYSE
SELECT
    s.id AS seat_id,
    s.seat_number,
    s.row_number,
    COALESCE(t.status, 'available') AS seat_status
FROM
    public.seats s
        JOIN public.seat_map sm ON s.id = sm.seat_id
        JOIN public.sessions ss ON sm.hall_id = ss.hall_id
        LEFT JOIN public.tickets t ON ss.id = t.session_id AND s.id = t.seat_map_id
WHERE
    ss.id = 4011;


-- Hash Right Join  (cost=52.49..271.58 rows=101 width=51) (actual time=0.444..0.835 rows=100 loops=1)
--    Hash Cond: (t.seat_map_id = s.id)
--    ->  Seq Scan on tickets t  (cost=0.00..219.00 rows=17 width=29) (actual time=0.044..0.517 rows=17 loops=1)
--          Filter: (session_id = 4011)
--          Rows Removed by Filter: 9982
--    ->  Hash  (cost=51.23..51.23 rows=101 width=23) (actual time=0.301..0.302 rows=100 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 14kB
--          ->  Hash Join  (cost=29.42..51.23 rows=101 width=23) (actual time=0.168..0.288 rows=100 loops=1)
--                Hash Cond: (s.id = sm.seat_id)
--                ->  Seq Scan on seats s  (cost=0.00..17.04 rows=1004 width=19) (actual time=0.004..0.049 rows=1
-- 004 loops=1)
--                ->  Hash  (cost=28.15..28.15 rows=101 width=8) (actual time=0.160..0.161 rows=100 loops=1)
--                      Buckets: 1024  Batches: 1  Memory Usage: 12kB
--                      ->  Hash Join  (cost=8.30..28.15 rows=101 width=8) (actual time=0.016..0.150 rows=100 loo
-- ps=1)
--                            Hash Cond: (sm.hall_id = ss.hall_id)
--                            ->  Seq Scan on seat_map sm  (cost=0.00..16.08 rows=1008 width=8) (actual time=0.00
-- 2..0.048 rows=1008 loops=1)
--                            ->  Hash  (cost=8.29..8.29 rows=1 width=8) (actual time=0.008..0.009 rows=1 loops=1
-- )
--                                  Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                  ->  Index Scan using sessions_pkey on sessions ss  (cost=0.28..8.29 rows=1 wi
-- dth=8) (actual time=0.006..0.007 rows=1 loops=1)
--                                        Index Cond: (id = 4011)
--  Planning Time: 0.366 ms
--  Execution Time: 0.859 ms

create index idx_session_id ON tickets(session_id);


-- Hash Right Join  (cost=56.91..101.40 rows=101 width=51) (actual time=0.293..0.315 rows=100 loops=1)
--    Hash Cond: (t.seat_map_id = s.id)
--    ->  Bitmap Heap Scan on tickets t  (cost=4.42..48.83 rows=17 width=29) (actual time=0.012..0.025 rows=17 lo
-- ops=1)
--          Recheck Cond: (session_id = 4011)
--          Heap Blocks: exact=15
--          ->  Bitmap Index Scan on idx_session_id  (cost=0.00..4.41 rows=17 width=0) (actual time=0.008..0.008
-- rows=17 loops=1)
--                Index Cond: (session_id = 4011)
--    ->  Hash  (cost=51.23..51.23 rows=101 width=23) (actual time=0.274..0.275 rows=100 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 14kB
--          ->  Hash Join  (cost=29.42..51.23 rows=101 width=23) (actual time=0.146..0.262 rows=100 loops=1)
--                Hash Cond: (s.id = sm.seat_id)
--                ->  Seq Scan on seats s  (cost=0.00..17.04 rows=1004 width=19) (actual time=0.004..0.047 rows=1
-- 004 loops=1)
--                ->  Hash  (cost=28.15..28.15 rows=101 width=8) (actual time=0.139..0.140 rows=100 loops=1)
--                      Buckets: 1024  Batches: 1  Memory Usage: 12kB
--                      ->  Hash Join  (cost=8.30..28.15 rows=101 width=8) (actual time=0.014..0.130 rows=100 loo
-- ps=1)
--                            Hash Cond: (sm.hall_id = ss.hall_id)
--                            ->  Seq Scan on seat_map sm  (cost=0.00..16.08 rows=1008 width=8) (actual time=0.00
-- 2..0.046 rows=1008 loops=1)
--                            ->  Hash  (cost=8.29..8.29 rows=1 width=8) (actual time=0.008..0.008 rows=1 loops=1
-- )
--                                  Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                                  ->  Index Scan using sessions_pkey on sessions ss  (cost=0.28..8.29 rows=1 wi
-- dth=8) (actual time=0.006..0.007 rows=1 loops=1)
--                                        Index Cond: (id = 4011)
--  Planning Time: 0.378 ms
--  Execution Time: 0.365 ms