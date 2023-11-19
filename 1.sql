-- Выбор всех фильмов на сегодня

EXPLAIN ANALYZE
SELECT
movies.name
FROM movies
    INNER JOIN sessions ON movies.id = sessions.movie_id
WHERE
    sessions.date = CURRENT_DATE;
;

-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Hash Join  (cost=244.68..397.11 rows=53 width=10) (actual time=2.606..5.197 rows=76 loops=1)
--    Hash Cond: (movies.id = sessions.movie_id)
--    ->  Seq Scan on movies  (cost=0.00..138.88 rows=1488 width=14) (actual time=0.010..1.680 rows=10000 loops=1)
--    ->  Hash  (cost=244.02..244.02 rows=53 width=4) (actual time=2.588..2.589 rows=76 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 11kB
--          ->  Seq Scan on sessions  (cost=0.00..244.02 rows=53 width=4) (actual time=0.006..1.838 rows=76 loops=1)
--                Filter: (date = CURRENT_DATE)
--                Rows Removed by Filter: 9924
--  Planning Time: 0.122 ms
--  Execution Time: 5.467 ms
-- (10 rows)

-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Gather  (cost=1000.43..284055.21 rows=52917 width=10) (actual time=9.995..1694.855 rows=82757 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Nested Loop  (cost=0.43..277763.51 rows=22049 width=10) (actual time=13.660..1635.992 rows=27586 loops=3)
--          ->  Parallel Seq Scan on sessions  (cost=0.00..149480.36 rows=22049 width=4) (actual time=13.520..944.574 rows=27586 loops=3)
--                Filter: (date = CURRENT_DATE)
--                Rows Removed by Filter: 3305748
--          ->  Index Scan using movies_pkey on movies  (cost=0.43..5.82 rows=1 width=14) (actual time=0.024..0.024 rows=1 loops=82757)
--                Index Cond: (id = sessions.movie_id)
--  Planning Time: 0.144 ms
--  JIT:
--    Functions: 24
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 3.065 ms, Inlining 0.000 ms, Optimization 2.109 ms, Emission 38.304 ms, Total 43.479 ms
--  Execution Time: 1732.622 ms
-- (15 rows)

CREATE INDEX ON sessions(date);

-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Hash Join  (cost=82.33..234.73 rows=50 width=10) (actual time=0.231..2.025 rows=76 loops=1)
--    Hash Cond: (movies.id = sessions.movie_id)
--    ->  Seq Scan on movies  (cost=0.00..138.88 rows=1488 width=14) (actual time=0.019..1.111 rows=10000 loops=1)
--    ->  Hash  (cost=81.70..81.70 rows=50 width=4) (actual time=0.206..0.207 rows=76 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 11kB
--          ->  Bitmap Heap Scan on sessions  (cost=4.68..81.70 rows=50 width=4) (actual time=0.126..0.186 rows=76 loops=1)
--                Recheck Cond: (date = CURRENT_DATE)
--                Heap Blocks: exact=49
--                ->  Bitmap Index Scan on sessions_date_idx  (cost=0.00..4.66 rows=50 width=0) (actual time=0.114..0.114 rows=76 loops=1)
--                      Index Cond: (date = CURRENT_DATE)
--  Planning Time: 0.241 ms
--  Execution Time: 2.299 ms
-- (12 rows)



-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Gather  (cost=1570.97..212483.07 rows=52917 width=10) (actual time=53.966..853.372 rows=82757 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Nested Loop  (cost=570.97..206191.37 rows=22049 width=10) (actual time=28.721..785.938 rows=27586 loops=3)
--          ->  Parallel Bitmap Heap Scan on sessions  (cost=570.54..77908.22 rows=22049 width=4) (actual time=20.835..231.097 rows=27586 loops=3)
--                Recheck Cond: (date = CURRENT_DATE)
--                Heap Blocks: exact=18891
--                ->  Bitmap Index Scan on sessions_date_idx  (cost=0.00..557.31 rows=52917 width=0) (actual time=37.610..37.610 rows=82757 loops=1)
--                      Index Cond: (date = CURRENT_DATE)
--          ->  Index Scan using movies_pkey on movies  (cost=0.43..5.82 rows=1 width=14) (actual time=0.018..0.018 rows=1 loops=82757)
--                Index Cond: (id = sessions.movie_id)
--  Planning Time: 0.186 ms
--  JIT:
--    Functions: 27
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 4.715 ms, Inlining 0.000 ms, Optimization 2.658 ms, Emission 31.850 ms, Total 39.223 ms
--  Execution Time: 876.515 ms
-- (17 rows)

