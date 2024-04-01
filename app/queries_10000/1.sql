-- Выбор всех фильмов на сегодня
EXPLAIN ANALYSE
SELECT movies.title
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
WHERE DATE(sessions.start_time) = CURRENT_DATE;

-- Hash Join  (cost=239.63..461.63 rows=50 width=15) (actual time=1.545..2.704 rows=333 loops=1)
--   Hash Cond: (movies.id = sessions.movie_id)
--   ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=19) (actual time=0.006..0.543 rows=10000 loops=1)
--   ->  Hash  (cost=239.00..239.00 rows=50 width=4) (actual time=1.531..1.531 rows=333 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 20kB
--         ->  Seq Scan on sessions  (cost=0.00..239.00 rows=50 width=4) (actual time=0.009..1.500 rows=333 loops=1)
--               Filter: (date(start_time) = CURRENT_DATE)
--               Rows Removed by Filter: 9667
-- Planning Time: 0.206 ms
-- Execution Time: 2.723 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);

-- Hash Join  (cost=239.63..461.63 rows=50 width=15) (actual time=1.562..2.711 rows=333 loops=1)
--   Hash Cond: (movies.id = sessions.movie_id)
--   ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=19) (actual time=0.008..0.532 rows=10000 loops=1)
--   ->  Hash  (cost=239.00..239.00 rows=50 width=4) (actual time=1.546..1.546 rows=333 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 20kB
--         ->  Seq Scan on sessions  (cost=0.00..239.00 rows=50 width=4) (actual time=0.010..1.514 rows=333 loops=1)
--               Filter: (date(start_time) = CURRENT_DATE)
--               Rows Removed by Filter: 9667
-- Planning Time: 0.181 ms
-- Execution Time: 2.735 ms