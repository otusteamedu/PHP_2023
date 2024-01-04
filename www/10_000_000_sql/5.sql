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


-- Nested Loop Left Join  (cost=29.43..2461.31 rows=101 width=51) (actual time=5.782..6.071 rows=100 loops=1)
--    Join Filter: (s.id = t.seat_map_id)
--    Rows Removed by Join Filter: 1698
--    ->  Hash Join  (cost=29.43..51.25 rows=101 width=23) (actual time=0.148..0.270 rows=100 loops=1)
--          Hash Cond: (s.id = sm.seat_id)
--          ->  Seq Scan on seats s  (cost=0.00..17.04 rows=1004 width=19) (actual time=0.004..0.049 rows=1004 lo
-- ops=1)
--          ->  Hash  (cost=28.17..28.17 rows=101 width=8) (actual time=0.141..0.142 rows=100 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 12kB
--                ->  Hash Join  (cost=8.32..28.17 rows=101 width=8) (actual time=0.014..0.131 rows=100 loops=1)
--                      Hash Cond: (sm.hall_id = ss.hall_id)
--                      ->  Seq Scan on seat_map sm  (cost=0.00..16.08 rows=1008 width=8) (actual time=0.002..0.0
-- 47 rows=1008 loops=1)
--                      ->  Hash  (cost=8.31..8.31 rows=1 width=8) (actual time=0.008..0.008 rows=1 loops=1)
--                            Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                            ->  Index Scan using sessions_pkey on sessions ss  (cost=0.29..8.31 rows=1 width=8)
--  (actual time=0.006..0.007 rows=1 loops=1)
--                                  Index Cond: (id = 4011)
--    ->  Materialize  (cost=0.00..2404.01 rows=4 width=29) (actual time=0.000..0.057 rows=17 loops=100)
--          ->  Seq Scan on tickets t  (cost=0.00..2403.99 rows=4 width=29) (actual time=0.042..5.627 rows=17 loo
-- ps=1)
--                Filter: (session_id = 4011)
--                Rows Removed by Filter: 109982
--  Planning Time: 0.241 ms
--  Execution Time: 6.096 ms

create index idx_session_id ON tickets(session_id);

-- Hash Left Join  (cost=49.07..71.65 rows=101 width=51) (actual time=0.168..0.296 rows=100 loops=1)
--    Hash Cond: (s.id = t.seat_map_id)
--    ->  Hash Join  (cost=29.43..51.25 rows=101 width=23) (actual time=0.146..0.262 rows=100 loops=1)
--          Hash Cond: (s.id = sm.seat_id)
--          ->  Seq Scan on seats s  (cost=0.00..17.04 rows=1004 width=19) (actual time=0.004..0.047 rows=1004 lo
-- ops=1)
--          ->  Hash  (cost=28.17..28.17 rows=101 width=8) (actual time=0.139..0.139 rows=100 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 12kB
--                ->  Hash Join  (cost=8.32..28.17 rows=101 width=8) (actual time=0.015..0.129 rows=100 loops=1)
--                      Hash Cond: (sm.hall_id = ss.hall_id)
--                      ->  Seq Scan on seat_map sm  (cost=0.00..16.08 rows=1008 width=8) (actual time=0.002..0.0
-- 46 rows=1008 loops=1)
--                      ->  Hash  (cost=8.31..8.31 rows=1 width=8) (actual time=0.008..0.008 rows=1 loops=1)
--                            Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                            ->  Index Scan using sessions_pkey on sessions ss  (cost=0.29..8.31 rows=1 width=8)
--  (actual time=0.006..0.007 rows=1 loops=1)
--                                  Index Cond: (id = 4011)
--    ->  Hash  (cost=19.58..19.58 rows=4 width=29) (actual time=0.020..0.020 rows=17 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 10kB
--          ->  Index Scan using idx_session_id on tickets t  (cost=0.29..19.58 rows=4 width=29) (actual time=0.0
-- 07..0.017 rows=17 loops=1)
--                Index Cond: (session_id = 4011)
--  Planning Time: 0.285 ms
--  Execution Time: 0.320 ms