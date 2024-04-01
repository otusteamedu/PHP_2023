-- Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYSE
SELECT movies.title, movies.genre, movies.duration, sessions.start_time
FROM movies
         JOIN sessions ON movies.id = sessions.movie_id
         JOIN halls ON halls.id = sessions.hall_id
WHERE sessions.start_time >= CURRENT_DATE
  AND sessions.start_time < CURRENT_DATE + INTERVAL '1 day';

-- Gather  (cost=357063.57..595138.07 rows=311663 width=41) (actual time=5021.260..5713.895 rows=333333 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Hash Join  (cost=356063.57..562971.77 rows=129860 width=41) (actual time=4996.452..5550.418 rows=111111 loops=3)
--         Hash Cond: (movies.id = sessions.movie_id)
--         ->  Parallel Seq Scan on movies  (cost=0.00..125001.00 rows=4166700 width=37) (actual time=0.020..1932.754 rows=3333333 loops=3)
--         ->  Parallel Hash  (cost=353805.32..353805.32 rows=129860 width=12) (actual time=2395.239..2395.239 rows=111111 loops=3)
--               Buckets: 131072  Batches: 8  Memory Usage: 3008kB
--               ->  Parallel Hash Join  (cost=159702.04..353805.32 rows=129860 width=12) (actual time=1994.475..2368.217 rows=111111 loops=3)
--                     Hash Cond: (halls.id = sessions.hall_id)
--                     ->  Parallel Seq Scan on halls  (cost=0.00..144750.33 rows=4166632 width=4) (actual time=0.034..449.902 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=157443.79..157443.79 rows=129860 width=16) (actual time=1154.166..1154.166 rows=111111 loops=3)
--                           Buckets: 131072  Batches: 8  Memory Usage: 3040kB
--                           ->  Parallel Seq Scan on sessions  (cost=0.00..157443.79 rows=129860 width=16) (actual time=0.071..1124.571 rows=111111 loops=3)
--                                 Filter: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                                 Rows Removed by Filter: 3222222
-- Planning Time: 0.258 ms
-- Execution Time: 5723.675 ms

CREATE INDEX ON sessions (start_time);
CREATE INDEX ON sessions (movie_id);
CREATE INDEX ON sessions (hall_id);

-- Gather  (cost=272855.71..510930.62 rows=311667 width=41) (actual time=2783.816..3507.772 rows=333333 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Parallel Hash Join  (cost=271855.71..478763.92 rows=129861 width=41) (actual time=2761.595..3336.373 rows=111111 loops=3)
--         Hash Cond: (movies.id = sessions.movie_id)
--         ->  Parallel Seq Scan on movies  (cost=0.00..125001.00 rows=4166700 width=37) (actual time=0.066..562.900 rows=3333333 loops=3)
--         ->  Parallel Hash  (cost=269597.44..269597.44 rows=129861 width=12) (actual time=1522.246..1522.246 rows=111111 loops=3)
--               Buckets: 131072  Batches: 8  Memory Usage: 3008kB
--               ->  Parallel Hash Join  (cost=75494.17..269597.44 rows=129861 width=12) (actual time=1081.933..1496.150 rows=111111 loops=3)
--                     Hash Cond: (halls.id = sessions.hall_id)
--                     ->  Parallel Seq Scan on halls  (cost=0.00..144750.33 rows=4166632 width=4) (actual time=0.059..443.953 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=73235.91..73235.91 rows=129861 width=16) (actual time=241.649..241.650 rows=111111 loops=3)
--                           Buckets: 131072  Batches: 8  Memory Usage: 3040kB
--                           ->  Parallel Bitmap Heap Scan on sessions  (cost=6619.03..73235.91 rows=129861 width=16) (actual time=18.607..216.531 rows=111111 loops=3)
--                                 Recheck Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
--                                 Heap Blocks: exact=22249
--                                 ->  Bitmap Index Scan on sessions_start_time_idx  (cost=0.00..6541.11 rows=311667 width=0) (actual time=28.105..28.105 rows=333333 loops=1)
--                                       Index Cond: ((start_time >= CURRENT_DATE) AND (start_time < (CURRENT_DATE + '1 day'::interval)))
-- Planning Time: 0.738 ms
-- Execution Time: 3517.332 ms