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

-- Limit  (cost=1500.03..1500.04 rows=3 width=47) (actual time=23.241..23.242 rows=3 loops=1)
--   ->  Sort  (cost=1500.03..1525.03 rows=10000 width=47) (actual time=23.240..23.240 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=1245.78..1370.78 rows=10000 width=47) (actual time=18.222..21.176 rows=10000 loops=1)
--               Group Key: movies.title
--               ->  Hash Join  (cost=962.00..1195.78 rows=10000 width=20) (actual time=7.589..14.615 rows=10000 loops=1)
--                     Hash Cond: (sessions.movie_id = movies.id)
--                     ->  Hash Join  (cost=653.00..860.52 rows=10000 width=9) (actual time=5.672..10.777 rows=10000 loops=1)
--                           Hash Cond: (tickets.sessions_id = sessions.id)
--                           ->  Hash Join  (cost=289.00..470.26 rows=10000 width=9) (actual time=2.194..5.277 rows=10000 loops=1)
--                                 Hash Cond: (orders.ticket_id = tickets.id)
--                                 ->  Seq Scan on orders  (cost=0.00..155.00 rows=10000 width=4) (actual time=0.012..0.859 rows=10000 loops=1)
--                                 ->  Hash  (cost=164.00..164.00 rows=10000 width=13) (actual time=2.144..2.144 rows=10000 loops=1)
--                                       Buckets: 16384  Batches: 1  Memory Usage: 597kB
--                                       ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.007..1.060 rows=10000 loops=1)
--                           ->  Hash  (cost=239.00..239.00 rows=10000 width=8) (actual time=3.399..3.399 rows=10000 loops=1)
--                                 Buckets: 16384  Batches: 1  Memory Usage: 519kB
--                                 ->  Seq Scan on sessions  (cost=0.00..239.00 rows=10000 width=8) (actual time=0.009..2.373 rows=10000 loops=1)
--                                       Filter: (start_time >= (CURRENT_DATE - '7 days'::interval))
--                     ->  Hash  (cost=184.00..184.00 rows=10000 width=19) (actual time=1.878..1.878 rows=10000 loops=1)
--                           Buckets: 16384  Batches: 1  Memory Usage: 636kB
--                           ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=19) (actual time=0.009..0.804 rows=10000 loops=1)
-- Planning Time: 0.734 ms
-- Execution Time: 23.847 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON tickets (sessions_id);
CREATE INDEX ON orders (ticket_id);
CREATE INDEX ON sessions (start_time);

-- Limit  (cost=1500.03..1500.04 rows=3 width=47) (actual time=21.799..21.800 rows=3 loops=1)
--   ->  Sort  (cost=1500.03..1525.03 rows=10000 width=47) (actual time=21.799..21.799 rows=3 loops=1)
--         Sort Key: (sum(tickets.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  HashAggregate  (cost=1245.78..1370.78 rows=10000 width=47) (actual time=17.176..19.776 rows=10000 loops=1)
--               Group Key: movies.title
--               ->  Hash Join  (cost=962.00..1195.78 rows=10000 width=20) (actual time=7.455..13.752 rows=10000 loops=1)
--                     Hash Cond: (sessions.movie_id = movies.id)
--                     ->  Hash Join  (cost=653.00..860.52 rows=10000 width=9) (actual time=5.557..10.105 rows=10000 loops=1)
--                           Hash Cond: (tickets.sessions_id = sessions.id)
--                           ->  Hash Join  (cost=289.00..470.26 rows=10000 width=9) (actual time=2.143..4.876 rows=10000 loops=1)
--                                 Hash Cond: (orders.ticket_id = tickets.id)
--                                 ->  Seq Scan on orders  (cost=0.00..155.00 rows=10000 width=4) (actual time=0.009..0.699 rows=10000 loops=1)
--                                 ->  Hash  (cost=164.00..164.00 rows=10000 width=13) (actual time=2.096..2.096 rows=10000 loops=1)
--                                       Buckets: 16384  Batches: 1  Memory Usage: 597kB
--                                       ->  Seq Scan on tickets  (cost=0.00..164.00 rows=10000 width=13) (actual time=0.006..0.902 rows=10000 loops=1)
--                           ->  Hash  (cost=239.00..239.00 rows=10000 width=8) (actual time=3.378..3.378 rows=10000 loops=1)
--                                 Buckets: 16384  Batches: 1  Memory Usage: 519kB
--                                 ->  Seq Scan on sessions  (cost=0.00..239.00 rows=10000 width=8) (actual time=0.010..2.368 rows=10000 loops=1)
--                                       Filter: (start_time >= (CURRENT_DATE - '7 days'::interval))
--                     ->  Hash  (cost=184.00..184.00 rows=10000 width=19) (actual time=1.862..1.862 rows=10000 loops=1)
--                           Buckets: 16384  Batches: 1  Memory Usage: 636kB
--                           ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=19) (actual time=0.007..0.803 rows=10000 loops=1)
-- Planning Time: 1.065 ms
-- Execution Time: 22.384 ms