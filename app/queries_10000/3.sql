-- Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYSE
SELECT movies.title, movies.genre, movies.duration, sessions.start_time
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.start_time >= CURRENT_DATE
  AND sessions.start_time < CURRENT_DATE + INTERVAL '1 day';

-- Hash Join  (cost=316.35..551.18 rows=333 width=38) (actual time=1.541..2.748 rows=333 loops=1)
--   Hash Cond: (halls.id = sessions.hall_id)
--   ->  Seq Scan on halls  (cost=0.00..194.00 rows=10000 width=4) (actual time=0.007..0.579 rows=10000 loops=1)
--   ->  Hash  (cost=312.19..312.19 rows=333 width=42) (actual time=1.518..1.518 rows=333 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 33kB
--         ->  Hash Join  (cost=87.36..312.19 rows=333 width=42) (actual time=0.200..1.450 rows=333 loops=1)
--               Hash Cond: (movies.id = sessions.movie_id)
--               ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=34) (actual time=0.006..0.578 rows=10000 loops=1)
--               ->  Hash  (cost=83.20..83.20 rows=333 width=16) (actual time=0.186..0.186 rows=333 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 24kB
--                     ->  Bitmap Heap Scan on sessions  (cost=11.71..83.20 rows=333 width=16) (actual time=0.042..0.146 rows=333 loops=1)
--                           Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                           Heap Blocks: exact=64
--                           ->  Bitmap Index Scan on sessions_start_time_idx  (cost=0.00..11.62 rows=333 width=0) (actual time=0.033..0.033 rows=333 loops=1)
--                                 Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
-- Planning Time: 0.288 ms
-- Execution Time: 2.810 ms

CREATE INDEX ON sessions (start_time);
CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);

-- Hash Join  (cost=312.35..547.18 rows=333 width=38) (actual time=1.439..2.610 rows=333 loops=1)
--   Hash Cond: (halls.id = sessions.hall_id)
--   ->  Seq Scan on halls  (cost=0.00..194.00 rows=10000 width=4) (actual time=0.005..0.546 rows=10000 loops=1)
--   ->  Hash  (cost=308.19..308.19 rows=333 width=42) (actual time=1.423..1.423 rows=333 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 33kB
--         ->  Hash Join  (cost=83.36..308.19 rows=333 width=42) (actual time=0.193..1.365 rows=333 loops=1)
--               Hash Cond: (movies.id = sessions.movie_id)
--               ->  Seq Scan on movies  (cost=0.00..184.00 rows=10000 width=34) (actual time=0.004..0.534 rows=10000 loops=1)
--               ->  Hash  (cost=79.20..79.20 rows=333 width=16) (actual time=0.180..0.180 rows=333 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 24kB
--                     ->  Bitmap Heap Scan on sessions  (cost=7.71..79.20 rows=333 width=16) (actual time=0.048..0.139 rows=333 loops=1)
--                           Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                           Heap Blocks: exact=64
--                           ->  Bitmap Index Scan on sessions_start_time_idx1  (cost=0.00..7.62 rows=333 width=0) (actual time=0.042..0.042 rows=333 loops=1)
--                                 Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
-- Planning Time: 0.657 ms
-- Execution Time: 2.655 ms