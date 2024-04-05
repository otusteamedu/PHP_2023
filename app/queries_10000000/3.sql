-- Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYSE
SELECT movies.title, movies.genre, movies.duration, sessions.start_time
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.start_time >= CURRENT_DATE
  AND sessions.start_time < CURRENT_DATE + INTERVAL '1 day';

-- Gather  (cost=357797.22..600019.28 rows=351667 width=41) (actual time=5438.920..6199.918 rows=333334 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Hash Join  (cost=356797.22..563852.58 rows=146528 width=41) (actual time=5384.519..5955.213 rows=111111 loops=3)
--         Hash Cond: (movies.id = sessions.movie_id)
--         ->  Parallel Seq Scan on movies  (cost=0.00..125000.06 rows=4166606 width=37) (actual time=0.050..533.125 rows=3333333 loops=3)
--         ->  Parallel Hash  (cost=354249.62..354249.62 rows=146528 width=12) (actual time=4191.505..4191.505 rows=111111 loops=3)
--               Buckets: 131072  Batches: 8  Memory Usage: 3008kB
--               ->  Parallel Hash Join  (cost=159992.60..354249.62 rows=146528 width=12) (actual time=3763.088..4165.055 rows=111111 loops=3)
--                     Hash Cond: (halls.id = sessions.hall_id)
--                     ->  Parallel Seq Scan on halls  (cost=0.00..144751.27 rows=4166727 width=4) (actual time=0.317..2154.051 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=157445.00..157445.00 rows=146528 width=16) (actual time=1187.496..1187.497 rows=111111 loops=3)
--                           Buckets: 131072  Batches: 8  Memory Usage: 3008kB
--                           ->  Parallel Seq Scan on sessions  (cost=0.00..157445.00 rows=146528 width=16) (actual time=0.060..1160.233 rows=111111 loops=3)
--                                 Filter: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                                 Rows Removed by Filter: 3222222
-- Planning Time: 14.899 ms
-- Execution Time: 6209.549 ms

CREATE INDEX ON sessions (start_time);
CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);

-- Gather  (cost=274813.13..517035.19 rows=351667 width=41) (actual time=2748.547..3466.835 rows=333334 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Hash Join  (cost=273813.13..480868.49 rows=146528 width=41) (actual time=2726.823..3273.286 rows=111111 loops=3)
--         Hash Cond: (movies.id = sessions.movie_id)
--         ->  Parallel Seq Scan on movies  (cost=0.00..125000.06 rows=4166606 width=37) (actual time=0.068..518.882 rows=3333333 loops=3)
--         ->  Parallel Hash  (cost=271265.53..271265.53 rows=146528 width=12) (actual time=1581.408..1581.408 rows=111111 loops=3)
--               Buckets: 131072  Batches: 8  Memory Usage: 3008kB
--               ->  Parallel Hash Join  (cost=77008.51..271265.53 rows=146528 width=12) (actual time=1179.399..1557.916 rows=111111 loops=3)
--                     Hash Cond: (halls.id = sessions.hall_id)
--                     ->  Parallel Seq Scan on halls  (cost=0.00..144751.27 rows=4166727 width=4) (actual time=0.062..489.782 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=74460.91..74460.91 rows=146528 width=16) (actual time=260.073..260.073 rows=111111 loops=3)
--                           Buckets: 131072  Batches: 8  Memory Usage: 3008kB
--                           ->  Parallel Bitmap Heap Scan on sessions  (cost=7469.03..74460.91 rows=146528 width=16) (actual time=21.395..223.912 rows=111111 loops=3)
--                                 Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                                 Heap Blocks: exact=21812
--                                 ->  Bitmap Index Scan on sessions_start_time_idx  (cost=0.00..7381.11 rows=351667 width=0) (actual time=30.550..30.550 rows=333334 loops=1)
--                                       Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
-- Planning Time: 0.871 ms
-- Execution Time: 3476.287 ms