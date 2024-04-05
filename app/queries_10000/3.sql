-- Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYSE
SELECT movies.title, movies.genre, movies.duration, sessions.start_time
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.start_time >= CURRENT_DATE
  AND sessions.start_time < CURRENT_DATE + INTERVAL '1 day';

-- Hash Join  (cost=522.16..756.99 rows=333 width=38) (actual time=4.372..5.545 rows=333 loops=1)
--   Hash Cond: (halls.id = sessions.hall_id)
--   ->  Seq Scan on halls  (cost=0.00..194.00 rows=10000 width=4) (actual time=0.007..0.552 rows=10000 loops=1)
--   ->  Hash  (cost=517.99..517.99 rows=333 width=42) (actual time=4.358..4.358 rows=333 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 33kB
--         ->  Hash Join  (cost=293.16..517.99 rows=333 width=42) (actual time=3.106..4.311 rows=333 loops=1)
--               Hash Cond: (movies.id = sessions.movie_id)
--               ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=34) (actual time=0.004..0.564 rows=10000 loops=1)
--               ->  Hash  (cost=289.00..289.00 rows=333 width=16) (actual time=3.095..3.095 rows=333 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 24kB
--                     ->  Seq Scan on sessions  (cost=0.00..289.00 rows=333 width=16) (actual time=0.016..3.052 rows=333 loops=1)
--                           Filter: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                           Rows Removed by Filter: 9667
-- Planning Time: 0.224 ms
-- Execution Time: 5.574 ms

CREATE INDEX ON sessions (start_time);
CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);

-- Hash Join  (cost=312.35..547.18 rows=333 width=38) (actual time=1.493..2.685 rows=333 loops=1)
--   Hash Cond: (halls.id = sessions.hall_id)
--   ->  Seq Scan on halls  (cost=0.00..194.00 rows=10000 width=4) (actual time=0.005..0.569 rows=10000 loops=1)
--   ->  Hash  (cost=308.19..308.19 rows=333 width=42) (actual time=1.474..1.474 rows=333 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 33kB
--         ->  Hash Join  (cost=83.36..308.19 rows=333 width=42) (actual time=0.198..1.415 rows=333 loops=1)
--               Hash Cond: (movies.id = sessions.movie_id)
--               ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=34) (actual time=0.004..0.561 rows=10000 loops=1)
--               ->  Hash  (cost=79.20..79.20 rows=333 width=16) (actual time=0.184..0.184 rows=333 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 24kB
--                     ->  Bitmap Heap Scan on sessions  (cost=7.71..79.20 rows=333 width=16) (actual time=0.046..0.143 rows=333 loops=1)
--                           Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                           Heap Blocks: exact=64
--                           ->  Bitmap Index Scan on sessions_start_time_idx1  (cost=0.00..7.62 rows=333 width=0) (actual time=0.039..0.039 rows=333 loops=1)
--                                 Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
-- Planning Time: 0.669 ms
-- Execution Time: 2.746 ms