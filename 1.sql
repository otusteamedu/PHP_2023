-- Выбор всех фильмов на сегодня

EXPLAIN ANALYZE
SELECT
movies.name,
movies.date_start,
movies.date_end
FROM movies
    INNER JOIN sessions ON movies.id = sessions.movie_id
WHERE
    (CURRENT_DATE BETWEEN movies.date_start AND movies.date_end)
;


-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Hash Join  (cost=167.47..621.26 rows=1380 width=19) (actual time=5.402..7.898 rows=692 loops=1)
--    Hash Cond: (sessions.movie_id = movies.id)
--    ->  Seq Scan on sessions  (cost=0.00..398.31 rows=21131 width=4) (actual time=1.044..2.035 rows=10000 loops=1)
--    ->  Hash  (cost=166.16..166.16 rows=105 width=23) (actual time=4.319..4.320 rows=692 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 46kB
--          ->  Seq Scan on movies  (cost=0.00..166.16 rows=105 width=23) (actual time=0.023..4.052 rows=692 loops=1)
--                Filter: ((CURRENT_DATE >= date_start) AND (CURRENT_DATE <= date_end))
--                Rows Removed by Filter: 9308
--  Planning Time: 1.228 ms
--  Execution Time: 8.812 ms
-- (10 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Gather  (cost=229850.07..443641.26 rows=342000 width=21) (actual time=4464.394..6763.409 rows=333634 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Parallel Hash Join  (cost=228850.07..408441.26 rows=142500 width=21) (actual time=4337.623..5967.986 rows=111211 loops=3)
--          Hash Cond: (sessions.movie_id = movies.id)
--          ->  Parallel Seq Scan on sessions  (cost=0.00..135124.69 rows=4166669 width=4) (actual time=0.308..1005.614 rows=3333333 loops=3)
--          ->  Parallel Hash  (cost=226093.84..226093.84 rows=142498 width=25) (actual time=1883.419..1883.421 rows=111211 loops=3)
--                Buckets: 65536  Batches: 8  Memory Usage: 3200kB
--                ->  Parallel Seq Scan on movies  (cost=0.00..226093.84 rows=142498 width=25) (actual time=33.524..1802.542 rows=111211 loops=3)
--                      Filter: ((CURRENT_DATE >= date_start) AND (CURRENT_DATE <= date_end))
--                      Rows Removed by Filter: 3222122
--  Planning Time: 0.293 ms
--  JIT:
--    Functions: 36
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 6.204 ms, Inlining 0.000 ms, Optimization 3.030 ms, Emission 90.195 ms, Total 99.429 ms
--  Execution Time: 6790.502 ms
-- (17 rows)

CREATE INDEX ON movies USING btree(date_start, date_end);

-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Hash Join  (cost=329.72..549.98 rows=349 width=18) (actual time=0.639..2.738 rows=349 loops=1)
--    Hash Cond: (sessions.movie_id = movies.id)
--    ->  Seq Scan on sessions  (cost=0.00..194.00 rows=10000 width=4) (actual time=0.007..0.963 rows=10000 loops=1)
--    ->  Hash  (cost=325.36..325.36 rows=349 width=22) (actual time=0.599..0.601 rows=349 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 28kB
--          ->  Bitmap Heap Scan on movies  (cost=184.38..325.36 rows=349 width=22) (actual time=0.197..0.486 rows=349 loops=1)
--                Filter: ((CURRENT_DATE >= date_start) AND (CURRENT_DATE <= date_end))
--                Heap Blocks: exact=123
--                ->  Bitmap Index Scan on movies_date_start_date_end_idx  (cost=0.00..184.29 rows=349 width=0) (actual time=0.170..0.170 rows=349 loops=1)
--                      Index Cond: ((date_start <= CURRENT_DATE) AND (date_end >= CURRENT_DATE))
--  Planning Time: 0.459 ms
--  Execution Time: 3.023 ms
-- (12 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Gather  (cost=229851.58..443642.78 rows=342000 width=21) (actual time=4404.167..6515.870 rows=333634 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Parallel Hash Join  (cost=228851.58..408442.78 rows=142500 width=21) (actual time=4392.852..6259.983 rows=111211 loops=3)
--          Hash Cond: (sessions.movie_id = movies.id)
--          ->  Parallel Seq Scan on sessions  (cost=0.00..135124.69 rows=4166669 width=4) (actual time=0.138..1290.645 rows=3333333 loops=3)
--          ->  Parallel Hash  (cost=226095.33..226095.33 rows=142500 width=25) (actual time=1979.255..1979.256 rows=111211 loops=3)
--                Buckets: 65536  Batches: 8  Memory Usage: 3200kB
--                ->  Parallel Seq Scan on movies  (cost=0.00..226095.33 rows=142500 width=25) (actual time=30.007..1807.271 rows=111211 loops=3)
--                      Filter: ((CURRENT_DATE >= date_start) AND (CURRENT_DATE <= date_end))
--                      Rows Removed by Filter: 3222122
--  Planning Time: 0.628 ms
--  JIT:
--    Functions: 36
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 5.313 ms, Inlining 0.000 ms, Optimization 2.973 ms, Emission 85.970 ms, Total 94.256 ms
--  Execution Time: 6562.773 ms
-- (17 rows)

