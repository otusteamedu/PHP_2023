-- Формирование афиши (фильмы, которые показывают сегодня)

EXPLAIN ANALYZE
SELECT
halls.name,
movies.name
FROM movies
    INNER JOIN sessions ON movies.id = sessions.movie_id
    INNER JOIN halls ON sessions.hall_id = halls.id
WHERE
    sessions.date = CURRENT_DATE;
;

-----------------------------------------100000------------------------------------------------------
-- Hash Join  (cost=257.83..410.40 rows=53 width=526) (actual time=2.246..5.948 rows=76 loops=1)
--    Hash Cond: (sessions.hall_id = halls.id)
--    ->  Hash Join  (cost=244.68..397.11 rows=53 width=14) (actual time=2.201..5.831 rows=76 loops=1)
--          Hash Cond: (movies.id = sessions.movie_id)
--          ->  Seq Scan on movies  (cost=0.00..138.88 rows=1488 width=14) (actual time=0.005..2.209 rows=10000 loops=1)
--          ->  Hash  (cost=244.02..244.02 rows=53 width=8) (actual time=2.179..2.181 rows=76 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 11kB
--                ->  Seq Scan on sessions  (cost=0.00..244.02 rows=53 width=8) (actual time=0.008..2.145 rows=76 loops=1)
--                      Filter: (date = CURRENT_DATE)
--                      Rows Removed by Filter: 9924
--    ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.037..0.038 rows=2 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 9kB
--          ->  Seq Scan on halls  (cost=0.00..11.40 rows=140 width=520) (actual time=0.015..0.017 rows=2 loops=1)
--  Planning Time: 1.411 ms
--  Execution Time: 6.078 ms
-- (15 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Gather  (cost=1013.58..284127.46 rows=52917 width=526) (actual time=19.502..1741.117 rows=82757 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Hash Join  (cost=13.58..277835.76 rows=22049 width=526) (actual time=17.921..1649.845 rows=27586 loops=3)
--          Hash Cond: (sessions.hall_id = halls.id)
--          ->  Nested Loop  (cost=0.43..277763.51 rows=22049 width=14) (actual time=17.576..1623.195 rows=27586 loops=3)
--                ->  Parallel Seq Scan on sessions  (cost=0.00..149480.36 rows=22049 width=8) (actual time=17.426..951.712 rows=27586 loops=3)
--                      Filter: (date = CURRENT_DATE)
--                      Rows Removed by Filter: 3305748
--                ->  Index Scan using movies_pkey on movies  (cost=0.43..5.82 rows=1 width=14) (actual time=0.023..0.023 rows=1 loops=82757)
--                      Index Cond: (id = sessions.movie_id)
--          ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.056..0.060 rows=2 loops=3)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on halls  (cost=0.00..11.40 rows=140 width=520) (actual time=0.032..0.034 rows=2 loops=3)
--  Planning Time: 0.385 ms
--  JIT:
--    Functions: 51
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 6.687 ms, Inlining 0.000 ms, Optimization 2.304 ms, Emission 49.797 ms, Total 58.787 ms
--  Execution Time: 1752.821 ms
-- (20 rows)

CREATE INDEX ON sessions(date);

-----------------------------------------100000------------------------------------------------------
-- Hash Join  (cost=95.48..248.01 rows=50 width=526) (actual time=0.158..2.686 rows=76 loops=1)
--    Hash Cond: (sessions.hall_id = halls.id)
--    ->  Hash Join  (cost=82.33..234.73 rows=50 width=14) (actual time=0.132..2.636 rows=76 loops=1)
--          Hash Cond: (movies.id = sessions.movie_id)
--          ->  Seq Scan on movies  (cost=0.00..138.88 rows=1488 width=14) (actual time=0.004..1.530 rows=10000 loops=1)
--          ->  Hash  (cost=81.70..81.70 rows=50 width=8) (actual time=0.117..0.119 rows=76 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 11kB
--                ->  Bitmap Heap Scan on sessions  (cost=4.68..81.70 rows=50 width=8) (actual time=0.042..0.102 rows=76 loops=1)
--                      Recheck Cond: (date = CURRENT_DATE)
--                      Heap Blocks: exact=49
--                      ->  Bitmap Index Scan on sessions_date_idx  (cost=0.00..4.66 rows=50 width=0) (actual time=0.030..0.030 rows=76 loops=1)
--                            Index Cond: (date = CURRENT_DATE)
--    ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.021..0.022 rows=2 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 9kB
--          ->  Seq Scan on halls  (cost=0.00..11.40 rows=140 width=520) (actual time=0.011..0.012 rows=2 loops=1)
--  Planning Time: 0.842 ms
--  Execution Time: 2.842 ms
-- (17 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Gather  (cost=1584.12..212555.32 rows=52917 width=526) (actual time=125.245..894.407 rows=82757 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Hash Join  (cost=584.12..206263.62 rows=22049 width=526) (actual time=75.773..815.440 rows=27586 loops=3)
--          Hash Cond: (sessions.hall_id = halls.id)
--          ->  Nested Loop  (cost=570.97..206191.37 rows=22049 width=14) (actual time=41.607..764.278 rows=27586 loops=3)
--                ->  Parallel Bitmap Heap Scan on sessions  (cost=570.54..77908.22 rows=22049 width=8) (actual time=41.471..231.828 rows=27586 loops=3)
--                      Recheck Cond: (date = CURRENT_DATE)
--                      Heap Blocks: exact=15554
--                      ->  Bitmap Index Scan on sessions_date_idx  (cost=0.00..557.31 rows=52917 width=0) (actual time=33.313..33.314 rows=82757 loops=1)
--                            Index Cond: (date = CURRENT_DATE)
--                ->  Index Scan using movies_pkey on movies  (cost=0.43..5.82 rows=1 width=14) (actual time=0.018..0.018 rows=1 loops=82757)
--                      Index Cond: (id = sessions.movie_id)
--          ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=31.919..31.920 rows=2 loops=3)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on halls  (cost=0.00..11.40 rows=140 width=520) (actual time=31.878..31.885 rows=2 loops=3)
--  Planning Time: 0.207 ms
--  JIT:
--    Functions: 54
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 6.021 ms, Inlining 0.000 ms, Optimization 2.651 ms, Emission 93.015 ms, Total 101.687 ms
--  Execution Time: 904.656 ms
-- (22 rows)
