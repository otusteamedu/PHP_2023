-- Выбор всех фильмов на сегодня
EXPLAIN ANALYSE
SELECT movies.title
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
WHERE DATE(sessions.start_time) = CURRENT_DATE;

-- Gather  (cost=1000.43..259732.99 rows=49999 width=18) (actual time=0.667..1316.717 rows=333334 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Nested Loop  (cost=0.43..253733.09 rows=20833 width=18) (actual time=0.112..1247.188 rows=111111 loops=3)
--         ->  Parallel Seq Scan on sessions  (cost=0.00..136610.73 rows=20833 width=4) (actual time=0.052..655.689 rows=111111 loops=3)
--               Filter: (date(start_time) = CURRENT_DATE)
--               Rows Removed by Filter: 3222222
--         ->  Index Scan using movies_pkey on movies  (cost=0.43..5.62 rows=1 width=22) (actual time=0.005..0.005 rows=1 loops=333334)
--               Index Cond: (id = sessions.movie_id)
-- Planning Time: 0.213 ms
-- Execution Time: 1326.448 ms

CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (start_time);

-- Gather  (cost=1000.43..259731.88 rows=50000 width=18) (actual time=0.711..1312.900 rows=333334 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Nested Loop  (cost=0.43..253731.88 rows=20833 width=18) (actual time=0.105..1244.535 rows=111111 loops=3)
--         ->  Parallel Seq Scan on sessions  (cost=0.00..136611.67 rows=20833 width=4) (actual time=0.043..661.648 rows=111111 loops=3)
--               Filter: (date(start_time) = CURRENT_DATE)
--               Rows Removed by Filter: 3222222
--         ->  Index Scan using movies_pkey on movies  (cost=0.43..5.62 rows=1 width=22) (actual time=0.005..0.005 rows=1 loops=333334)
--               Index Cond: (id = sessions.movie_id)
-- Planning Time: 0.248 ms
-- Execution Time: 1322.574 ms