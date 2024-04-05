-- Выбор всех фильмов на сегодня
EXPLAIN ANALYSE
SELECT movies.title
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
WHERE DATE(sessions.start_time) = CURRENT_DATE;

-- Hash Join  (cost=239.63..461.63 rows=50 width=15) (actual time=1.631..2.814 rows=333 loops=1)
--   Hash Cond: (movies.id = sessions.movie_id)
--   ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=19) (actual time=0.010..0.566 rows=10000 loops=1)
--   ->  Hash  (cost=239.00..239.00 rows=50 width=4) (actual time=1.608..1.608 rows=333 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 20kB
--         ->  Seq Scan on sessions  (cost=0.00..239.00 rows=50 width=4) (actual time=0.015..1.568 rows=333 loops=1)
--               Filter: (date(start_time) = CURRENT_DATE)
--               Rows Removed by Filter: 9667
-- Planning Time: 0.265 ms
-- Execution Time: 2.843 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);

-- Hash Join  (cost=239.63..461.63 rows=50 width=15) (actual time=1.600..2.752 rows=333 loops=1)
--   Hash Cond: (movies.id = sessions.movie_id)
--   ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=19) (actual time=0.007..0.541 rows=10000 loops=1)
--   ->  Hash  (cost=239.00..239.00 rows=50 width=4) (actual time=1.583..1.583 rows=333 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 20kB
--         ->  Seq Scan on sessions  (cost=0.00..239.00 rows=50 width=4) (actual time=0.010..1.538 rows=333 loops=1)
--               Filter: (date(start_time) = CURRENT_DATE)
--               Rows Removed by Filter: 9667
-- Planning Time: 0.467 ms
-- Execution Time: 2.775 ms