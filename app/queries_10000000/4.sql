-- Поиск 3 самых прибыльных фильмов за неделю
EXPLAIN ANALYSE
SELECT movies.title, SUM(tickets.price) AS total_revenue
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN tickets ON tickets.sessions_id = sessions.id
         JOIN orders ON orders.ticket_id = tickets.id
WHERE sessions.start_time >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY movies.title
ORDER BY total_revenue DESC
LIMIT 3;

-- Limit  (cost=2879766.86..2879766.87 rows=3 width=50) (actual time=73172.573..73172.573 rows=3 loops=1)
--   ->  Sort  (cost=2879766.86..2904766.86 rows=10000000 width=50) (actual time=73172.572..73172.572 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=1517811.88..2750518.73 rows=10000000 width=50) (actual time=40849.419..70672.104 rows=10000000 loops=1)
--               Group Key: movies.title
--               ->  Gather Merge  (cost=1517811.88..2563018.73 rows=8333334 width=50) (actual time=40849.414..63239.533 rows=10000000 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=1516811.85..1600145.19 rows=4166667 width=50) (actual time=40742.130..49736.524 rows=3333333 loops=3)
--                           Group Key: movies.title
--                           ->  Sort  (cost=1516811.85..1527228.52 rows=4166667 width=23) (actual time=40742.112..47050.017 rows=3333333 loops=3)
--                                 Sort Key: movies.title
--                                 Sort Method: external merge  Disk: 110384kB
--                                 Worker 0:  Sort Method: external merge  Disk: 110392kB
--                                 Worker 1:  Sort Method: external merge  Disk: 110720kB
--                                 ->  Parallel Hash Join  (cost=584262.01..887772.18 rows=4166667 width=23) (actual time=8708.054..9976.095 rows=3333333 loops=3)
--                                       Hash Cond: (sessions.movie_id = movies.id)
--                                       ->  Parallel Hash Join  (cost=382763.01..610228.68 rows=4166667 width=9) (actual time=5537.519..6898.292 rows=3333333 loops=3)
--                                             Hash Cond: (tickets.sessions_id = sessions.id)
--                                             ->  Parallel Hash Join  (cost=177791.00..337350.17 rows=4166667 width=9) (actual time=1999.985..3245.190 rows=3333333 loops=3)
--                                                   Hash Cond: (orders.ticket_id = tickets.id)
--                                                   ->  Parallel Seq Scan on orders  (cost=0.00..95721.67 rows=4166667 width=4) (actual time=0.084..357.279 rows=3333333 loops=3)
--                                                   ->  Parallel Hash  (cost=105361.67..105361.67 rows=4166667 width=13) (actual time=1109.254..1109.255 rows=3333333 loops=3)
--                                                         Buckets: 131072  Batches: 256  Memory Usage: 2912kB
--                                                         ->  Parallel Seq Scan on tickets  (cost=0.00..105361.67 rows=4166667 width=13) (actual time=0.015..449.442 rows=3333333 loops=3)
--                                             ->  Parallel Hash  (cost=136611.67..136611.67 rows=4166667 width=8) (actual time=1610.060..1610.061 rows=3333333 loops=3)
--                                                   Buckets: 131072  Batches: 256  Memory Usage: 2592kB
--                                                   ->  Parallel Seq Scan on sessions  (cost=0.00..136611.67 rows=4166667 width=8) (actual time=0.068..971.186 rows=3333333 loops=3)
--                                                         Filter: (start_time >= (CURRENT_DATE - '7 days'::interval))
--                                       ->  Parallel Hash  (cost=125000.67..125000.67 rows=4166667 width=22) (actual time=1127.892..1127.892 rows=3333333 loops=3)
--                                             Buckets: 65536  Batches: 256  Memory Usage: 2720kB
--                                             ->  Parallel Seq Scan on movies  (cost=0.00..125000.67 rows=4166667 width=22) (actual time=0.009..469.930 rows=3333333 loops=3)
-- Planning Time: 1.164 ms
-- Execution Time: 74073.217 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON tickets (sessions_id);
CREATE INDEX ON orders (ticket_id);
CREATE INDEX ON sessions (start_time);

-- Limit  (cost=2879766.86..2879766.87 rows=3 width=50) (actual time=74444.931..74444.931 rows=3 loops=1)
--   ->  Sort  (cost=2879766.86..2904766.86 rows=10000000 width=50) (actual time=74444.930..74444.930 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=1517811.88..2750518.73 rows=10000000 width=50) (actual time=41893.811..71921.956 rows=10000000 loops=1)
--               Group Key: movies.title
--               ->  Gather Merge  (cost=1517811.88..2563018.73 rows=8333334 width=50) (actual time=41893.791..64467.828 rows=10000000 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=1516811.85..1600145.19 rows=4166667 width=50) (actual time=41787.449..50856.986 rows=3333333 loops=3)
--                           Group Key: movies.title
--                           ->  Sort  (cost=1516811.85..1527228.52 rows=4166667 width=23) (actual time=41787.432..48147.293 rows=3333333 loops=3)
--                                 Sort Key: movies.title
--                                 Sort Method: external merge  Disk: 110360kB
--                                 Worker 0:  Sort Method: external merge  Disk: 110760kB
--                                 Worker 1:  Sort Method: external merge  Disk: 110368kB
--                                 ->  Parallel Hash Join  (cost=584262.01..887772.18 rows=4166667 width=23) (actual time=8716.451..10052.939 rows=3333333 loops=3)
--                                       Hash Cond: (sessions.movie_id = movies.id)
--                                       ->  Parallel Hash Join  (cost=382763.01..610228.68 rows=4166667 width=9) (actual time=5474.907..6921.509 rows=3333333 loops=3)
--                                             Hash Cond: (tickets.sessions_id = sessions.id)
--                                             ->  Parallel Hash Join  (cost=177791.00..337350.17 rows=4166667 width=9) (actual time=1993.970..3227.016 rows=3333333 loops=3)
--                                                   Hash Cond: (orders.ticket_id = tickets.id)
--                                                   ->  Parallel Seq Scan on orders  (cost=0.00..95721.67 rows=4166667 width=4) (actual time=0.079..353.247 rows=3333333 loops=3)
--                                                   ->  Parallel Hash  (cost=105361.67..105361.67 rows=4166667 width=13) (actual time=1091.987..1091.987 rows=3333333 loops=3)
--                                                         Buckets: 131072  Batches: 256  Memory Usage: 2912kB
--                                                         ->  Parallel Seq Scan on tickets  (cost=0.00..105361.67 rows=4166667 width=13) (actual time=0.016..445.334 rows=3333333 loops=3)
--                                             ->  Parallel Hash  (cost=136611.67..136611.67 rows=4166667 width=8) (actual time=1557.105..1557.106 rows=3333333 loops=3)
--                                                   Buckets: 131072  Batches: 256  Memory Usage: 2592kB
--                                                   ->  Parallel Seq Scan on sessions  (cost=0.00..136611.67 rows=4166667 width=8) (actual time=0.103..959.901 rows=3333333 loops=3)
--                                                         Filter: (start_time >= (CURRENT_DATE - '7 days'::interval))
--                                       ->  Parallel Hash  (cost=125000.67..125000.67 rows=4166667 width=22) (actual time=1102.754..1102.754 rows=3333333 loops=3)
--                                             Buckets: 65536  Batches: 256  Memory Usage: 2720kB
--                                             ->  Parallel Seq Scan on movies  (cost=0.00..125000.67 rows=4166667 width=22) (actual time=0.211..463.893 rows=3333333 loops=3)
-- Planning Time: 0.600 ms
-- Execution Time: 75370.922 ms