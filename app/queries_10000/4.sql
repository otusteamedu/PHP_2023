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

-- Limit  (cost=754.48..754.49 rows=3 width=51) (actual time=6.016..6.016 rows=3 loops=1)
--   ->  Sort  (cost=754.48..756.89 rows=961 width=51) (actual time=6.014..6.015 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=730.05..742.06 rows=961 width=51) (actual time=5.554..5.802 rows=961 loops=1)
--               Group Key: movies.id
--               ->  Hash Join  (cost=494.13..725.25 rows=961 width=24) (actual time=3.849..5.169 rows=961 loops=1)
--                     Hash Cond: (movies.id = sessions.movie_id)
--                     ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=19) (actual time=0.009..0.525 rows=10000 loops=1)
--                     ->  Hash  (cost=482.12..482.12 rows=961 width=9) (actual time=3.829..3.829 rows=961 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 47kB
--                           ->  Hash Join  (cost=271.01..482.12 rows=961 width=9) (actual time=2.447..3.721 rows=961 loops=1)
--                                 Hash Cond: (sessions.id = tickets.sessions_id)
--                                 ->  Seq Scan on sessions  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.006..0.537 rows=10000 loops=1)
--                                 ->  Hash  (cost=259.00..259.00 rows=961 width=9) (actual time=2.431..2.432 rows=961 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 50kB
--                                       ->  Seq Scan on tickets  (cost=0.00..259.00 rows=961 width=9) (actual time=0.009..2.288 rows=961 loops=1)
--                                             Filter: (created_at >= (CURRENT_DATE - '7 days'::interval))
--                                             Rows Removed by Filter: 9039
-- Planning Time: 0.342 ms
-- Execution Time: 6.127 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);
CREATE INDEX ON tickets (sessions_id);
CREATE INDEX ON tickets (created_at);

-- Limit  (cost=616.04..616.05 rows=3 width=51) (actual time=4.131..4.132 rows=3 loops=1)
--   ->  Sort  (cost=616.04..618.44 rows=961 width=51) (actual time=4.131..4.131 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=591.61..603.62 rows=961 width=51) (actual time=3.653..3.920 rows=961 loops=1)
--               Group Key: movies.id
--               ->  Hash Join  (cost=355.69..586.80 rows=961 width=24) (actual time=1.844..3.225 rows=961 loops=1)
--                     Hash Cond: (movies.id = sessions.movie_id)
--                     ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=19) (actual time=0.006..0.556 rows=10000 loops=1)
--                     ->  Hash  (cost=343.68..343.68 rows=961 width=9) (actual time=1.830..1.830 rows=961 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 47kB
--                           ->  Hash Join  (cost=132.57..343.68 rows=961 width=9) (actual time=0.415..1.709 rows=961 loops=1)
--                                 Hash Cond: (sessions.id = tickets.sessions_id)
--                                 ->  Seq Scan on sessions  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.005..0.503 rows=10000 loops=1)
--                                 ->  Hash  (cost=120.56..120.56 rows=961 width=9) (actual time=0.400..0.400 rows=961 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 50kB
--                                       ->  Bitmap Heap Scan on tickets  (cost=19.74..120.56 rows=961 width=9) (actual time=0.084..0.290 rows=961 loops=1)
--                                             Recheck Cond: (created_at >= (CURRENT_DATE - '7 days'::interval))
--                                             Heap Blocks: exact=84
--                                             ->  Bitmap Index Scan on tickets_created_at_idx  (cost=0.00..19.50 rows=961 width=0) (actual time=0.075..0.075 rows=961 loops=1)
--                                                   Index Cond: (created_at >= (CURRENT_DATE - '7 days'::interval))
-- Planning Time: 0.805 ms
-- Execution Time: 4.272 ms