-- Формирование афиши (фильмы, которые показывают сегодня)

EXPLAIN ANALYZE
SELECT
halls.name,
movies.name,
movies.date_start,
movies.date_end
FROM movies
    INNER JOIN sessions ON movies.id = sessions.movie_id
    INNER JOIN halls ON sessions.hall_id = halls.id
WHERE
    (CURRENT_DATE BETWEEN movies.date_start AND movies.date_end)
;

-----------------------------------------100000------------------------------------------------------
-- Hash Join  (cost=180.62..638.15 rows=1380 width=535) (actual time=3.916..6.561 rows=692 loops=1)
--    Hash Cond: (sessions.hall_id = halls.id)
--    ->  Hash Join  (cost=167.47..621.26 rows=1380 width=23) (actual time=3.867..6.376 rows=692 loops=1)
--          Hash Cond: (sessions.movie_id = movies.id)
--          ->  Seq Scan on sessions  (cost=0.00..398.31 rows=21131 width=8) (actual time=0.211..1.471 rows=10000 loops=1)
--          ->  Hash  (cost=166.16..166.16 rows=105 width=23) (actual time=3.622..3.623 rows=692 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 46kB
--                ->  Seq Scan on movies  (cost=0.00..166.16 rows=105 width=23) (actual time=0.029..3.395 rows=692 loops=1)
--                      Filter: ((CURRENT_DATE >= date_start) AND (CURRENT_DATE <= date_end))
--                      Rows Removed by Filter: 9308
--    ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.030..0.030 rows=2 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 9kB
--          ->  Seq Scan on halls  (cost=0.00..11.40 rows=140 width=520) (actual time=0.013..0.014 rows=2 loops=1)
--  Planning Time: 2.810 ms
--  Execution Time: 6.700 ms
-- (15 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Gather  (cost=229863.22..444039.80 rows=342000 width=537) (actual time=4689.070..6889.717 rows=333634 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Hash Join  (cost=228863.22..408839.80 rows=142500 width=537) (actual time=4635.781..6436.749 rows=111211 loops=3)
--          Hash Cond: (sessions.hall_id = halls.id)
--          ->  Parallel Hash Join  (cost=228850.07..408441.26 rows=142500 width=25) (actual time=4592.941..6357.840 rows=111211 loops=3)
--                Hash Cond: (sessions.movie_id = movies.id)
--                ->  Parallel Seq Scan on sessions  (cost=0.00..135124.69 rows=4166669 width=8) (actual time=0.060..1069.462 rows=3333333 loops=3)
--                ->  Parallel Hash  (cost=226093.84..226093.84 rows=142498 width=25) (actual time=1917.262..1917.264 rows=111211 loops=3)
--                      Buckets: 65536  Batches: 8  Memory Usage: 3168kB
--                      ->  Parallel Seq Scan on movies  (cost=0.00..226093.84 rows=142498 width=25) (actual time=0.077..1550.672 rows=111211 loops=3)
--                            Filter: ((CURRENT_DATE >= date_start) AND (CURRENT_DATE <= date_end))
--                            Rows Removed by Filter: 3222122
--          ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=42.442..42.443 rows=2 loops=3)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on halls  (cost=0.00..11.40 rows=140 width=520) (actual time=42.412..42.418 rows=2 loops=3)
--  Planning Time: 0.555 ms
--  JIT:
--    Functions: 60
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 5.857 ms, Inlining 0.000 ms, Optimization 4.328 ms, Emission 123.095 ms, Total 133.280 ms
--  Execution Time: 6921.658 ms
-- (22 rows)


CREATE INDEX ON movies USING btree(date_start, date_end);


-----------------------------------------100000------------------------------------------------------
--QUERY PLAN
-- Hash Join  (cost=342.87..564.07 rows=349 width=534) (actual time=1.806..8.046 rows=349 loops=1)
--    Hash Cond: (sessions.hall_id = halls.id)
--    ->  Hash Join  (cost=329.72..549.98 rows=349 width=22) (actual time=1.758..7.807 rows=349 loops=1)
--          Hash Cond: (sessions.movie_id = movies.id)
--          ->  Seq Scan on sessions  (cost=0.00..194.00 rows=10000 width=8) (actual time=0.005..2.313 rows=10000 loops=1)
--          ->  Hash  (cost=325.36..325.36 rows=349 width=22) (actual time=1.722..1.723 rows=349 loops=1)
--                Buckets: 1024  Batches: 1  Memory Usage: 28kB
--                ->  Bitmap Heap Scan on movies  (cost=184.38..325.36 rows=349 width=22) (actual time=0.963..1.450 rows=349 loops=1)
--                      Filter: ((CURRENT_DATE >= date_start) AND (CURRENT_DATE <= date_end))
--                      Heap Blocks: exact=123
--                      ->  Bitmap Index Scan on movies_date_start_date_end_idx  (cost=0.00..184.29 rows=349 width=0) (actual time=0.932..0.932 rows=349 loops=1)
--                            Index Cond: ((date_start <= CURRENT_DATE) AND (date_end >= CURRENT_DATE))
--    ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.028..0.028 rows=2 loops=1)
--          Buckets: 1024  Batches: 1  Memory Usage: 9kB
--          ->  Seq Scan on halls  (cost=0.00..11.40 rows=140 width=520) (actual time=0.011..0.013 rows=2 loops=1)
--  Planning Time: 1.435 ms
--  Execution Time: 8.431 ms
-- (17 rows)


-----------------------------------------10000000----------------------------------------------------
--QUERY PLAN
-- Gather  (cost=229864.73..444041.32 rows=342000 width=537) (actual time=4721.857..6778.274 rows=333634 loops=1)
--    Workers Planned: 2
--    Workers Launched: 2
--    ->  Hash Join  (cost=228864.73..408841.32 rows=142500 width=537) (actual time=4670.657..6285.957 rows=111211 loops=3)
--          Hash Cond: (sessions.hall_id = halls.id)
--          ->  Parallel Hash Join  (cost=228851.58..408442.78 rows=142500 width=25) (actual time=4635.621..6208.666 rows=111211 loops=3)
--                Hash Cond: (sessions.movie_id = movies.id)
--                ->  Parallel Seq Scan on sessions  (cost=0.00..135124.69 rows=4166669 width=8) (actual time=0.057..1175.681 rows=3333333 loops=3)
--                ->  Parallel Hash  (cost=226095.33..226095.33 rows=142500 width=25) (actual time=2003.670..2003.671 rows=111211 loops=3)
--                      Buckets: 65536  Batches: 8  Memory Usage: 3200kB
--                      ->  Parallel Seq Scan on movies  (cost=0.00..226095.33 rows=142500 width=25) (actual time=2.685..1885.213 rows=111211 loops=3)
--                            Filter: ((CURRENT_DATE >= date_start) AND (CURRENT_DATE <= date_end))
--                            Rows Removed by Filter: 3222122
--          ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=34.623..34.624 rows=2 loops=3)
--                Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                ->  Seq Scan on halls  (cost=0.00..11.40 rows=140 width=520) (actual time=34.587..34.596 rows=2 loops=3)
--  Planning Time: 0.960 ms
--  JIT:
--    Functions: 60
--    Options: Inlining false, Optimization false, Expressions true, Deforming true
--    Timing: Generation 8.890 ms, Inlining 0.000 ms, Optimization 4.489 ms, Emission 99.448 ms, Total 112.828 ms
--  Execution Time: 6808.420 ms
-- (22 rows)

