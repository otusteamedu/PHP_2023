-- Поиск 3 самых прибыльных фильмов за неделю
EXPLAIN ANALYSE
SELECT movies.title, SUM(tickets.price) AS total_revenue
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN tickets ON tickets.sessions_id = sessions.id
WHERE tickets.created_at >= CURRENT_DATE - INTERVAL '7 days'
GROUP BY movies.id
ORDER BY total_revenue DESC
LIMIT 3;

-- Limit  (cost=622852.97..622852.98 rows=3 width=54) (actual time=6976.049..6976.049 rows=3 loops=1)
--   ->  Sort  (cost=622852.97..624792.14 rows=775667 width=54) (actual time=6976.048..6976.048 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=517210.52..612827.62 rows=775667 width=54) (actual time=5839.022..6798.894 rows=798007 loops=1)
--               Group Key: movies.id
--               ->  Gather Merge  (cost=517210.52..598283.86 rows=646390 width=54) (actual time=5839.011..6259.193 rows=798007 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=516210.49..522674.39 rows=323195 width=54) (actual time=5815.267..6045.214 rows=266002 loops=3)
--                           Group Key: movies.id
--                           ->  Sort  (cost=516210.49..517018.48 rows=323195 width=27) (actual time=5804.801..5844.446 rows=266002 loops=3)
--                                 Sort Key: movies.id
--                                 Sort Method: external merge  Disk: 9896kB
--                                 Worker 0:  Sort Method: external merge  Disk: 9872kB
--                                 Worker 1:  Sort Method: external merge  Disk: 9904kB
--                                 ->  Nested Loop  (cost=161870.04..478899.84 rows=323195 width=27) (actual time=1827.411..5692.781 rows=266002 loops=3)
--                                       ->  Parallel Hash Join  (cost=161869.60..318335.92 rows=323195 width=9) (actual time=1827.297..2618.210 rows=266002 loops=3)
--                                             Hash Cond: (sessions.id = tickets.sessions_id)
--                                             ->  Parallel Seq Scan on sessions  (cost=0.00..105361.67 rows=4166667 width=8) (actual time=0.103..400.892 rows=3333333 loops=3)
--                                             ->  Parallel Hash  (cost=156250.67..156250.67 rows=323195 width=9) (actual time=1005.849..1005.849 rows=266002 loops=3)
--                                                   Buckets: 131072  Batches: 16  Memory Usage: 3424kB
--                                                   ->  Parallel Seq Scan on tickets  (cost=0.00..156250.67 rows=323195 width=9) (actual time=0.055..949.874 rows=266002 loops=3)
--                                                         Filter: (created_at >= (CURRENT_DATE - '7 days'::interval))
--                                                         Rows Removed by Filter: 3067331
--                                       ->  Index Scan using movies_pkey on movies  (cost=0.43..0.50 rows=1 width=22) (actual time=0.011..0.011 rows=1 loops=798007)
--                                             Index Cond: (id = sessions.movie_id)
-- Planning Time: 2.317 ms
-- Execution Time: 7025.555 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);
CREATE INDEX ON tickets (sessions_id);
CREATE INDEX ON tickets (created_at);

-- Limit  (cost=610937.04..610937.05 rows=3 width=54) (actual time=6751.325..6751.326 rows=3 loops=1)
--   ->  Sort  (cost=610937.04..612876.21 rows=775667 width=54) (actual time=6751.325..6751.325 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=505294.58..600911.69 rows=775667 width=54) (actual time=5616.600..6574.760 rows=798007 loops=1)
--               Group Key: movies.id
--               ->  Gather Merge  (cost=505294.58..586367.93 rows=646390 width=54) (actual time=5616.592..6040.715 rows=798007 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=504294.56..510758.46 rows=323195 width=54) (actual time=5591.841..5822.676 rows=266002 loops=3)
--                           Group Key: movies.id
--                           ->  Sort  (cost=504294.56..505102.55 rows=323195 width=27) (actual time=5591.827..5631.680 rows=266002 loops=3)
--                                 Sort Key: movies.id
--                                 Sort Method: external merge  Disk: 9872kB
--                                 Worker 0:  Sort Method: external merge  Disk: 9920kB
--                                 Worker 1:  Sort Method: external merge  Disk: 9880kB
--                                 ->  Nested Loop  (cost=149954.10..466983.91 rows=323195 width=27) (actual time=1456.811..5474.581 rows=266002 loops=3)
--                                       ->  Parallel Hash Join  (cost=149953.67..306419.99 rows=323195 width=9) (actual time=1456.733..2294.503 rows=266002 loops=3)
--                                             Hash Cond: (sessions.id = tickets.sessions_id)
--                                             ->  Parallel Seq Scan on sessions  (cost=0.00..105361.67 rows=4166667 width=8) (actual time=0.063..392.279 rows=3333333 loops=3)
--                                             ->  Parallel Hash  (cost=144334.73..144334.73 rows=323195 width=9) (actual time=651.811..651.811 rows=266002 loops=3)
--                                                   Buckets: 131072  Batches: 16  Memory Usage: 3424kB
--                                                   ->  Parallel Bitmap Heap Scan on tickets  (cost=14531.86..144334.73 rows=323195 width=9) (actual time=39.637..591.021 rows=266002 loops=3)
--                                                         Recheck Cond: (created_at >= (CURRENT_DATE - '7 days'::interval))
--                                                         Rows Removed by Index Recheck: 1217056
--                                                         Heap Blocks: exact=17034 lossy=11364
--                                                         ->  Bitmap Index Scan on tickets_created_at_idx  (cost=0.00..14337.94 rows=775667 width=0) (actual time=56.489..56.489 rows=798007 loops=1)
--                                                               Index Cond: (created_at >= (CURRENT_DATE - '7 days'::interval))
--                                       ->  Index Scan using movies_pkey on movies  (cost=0.43..0.50 rows=1 width=22) (actual time=0.012..0.012 rows=1 loops=798007)
--                                             Index Cond: (id = sessions.movie_id)
-- Planning Time: 1.010 ms
-- Execution Time: 6803.699 ms