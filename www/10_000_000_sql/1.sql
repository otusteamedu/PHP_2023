EXPLAIN ANALYSE
SELECT DISTINCT movies.name
FROM
    sessions LEFT JOIN movies ON movies.id = sessions.movie_id
WHERE
    sessions.datetime BETWEEN current_date AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;

-- HashAggregate  (cost=5620.58..5636.47 rows=1589 width=278) (actual time=30.481..30.635 rows=1524 loops=1)
--    Group Key: movies.name
--    Batches: 1  Memory Usage: 1089kB
--    ->  Merge Right Join  (cost=3506.28..5616.60 rows=1589 width=278) (actual time=23.601..29.902 rows=1581 loo
-- ps=1)
--          Merge Cond: (movies.id = sessions.movie_id)
--          ->  Index Scan using movies_pkey on movies  (cost=0.29..7417.29 rows=110000 width=282) (actual time=0
-- .005..4.542 rows=29987 loops=1)
--          ->  Sort  (cost=3505.99..3509.96 rows=1589 width=4) (actual time=23.586..23.647 rows=1581 loops=1)
--                Sort Key: sessions.movie_id
--                Sort Method: quicksort  Memory: 49kB
--                ->  Seq Scan on sessions  (cost=0.00..3421.50 rows=1589 width=4) (actual time=0.075..23.446 row
-- s=1581 loops=1)
--                      Filter: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59')):
-- :timestamp without time zone))
--                      Rows Removed by Filter: 99419
--  Planning Time: 0.266 ms
--  Execution Time: 30.714 ms

-- create index --
create index idx_sessions_datetime on sessions(datetime);


-- HashAggregate  (cost=2923.37..2939.26 rows=1589 width=278) (actual time=7.517..7.659 rows=1524 loops=1)
--    Group Key: movies.name
--    Batches: 1  Memory Usage: 1089kB
--    ->  Merge Right Join  (cost=809.07..2919.39 rows=1589 width=278) (actual time=0.924..6.954 rows=1581 loops=
-- 1)
--          Merge Cond: (movies.id = sessions.movie_id)
--          ->  Index Scan using movies_pkey on movies  (cost=0.29..7417.29 rows=110000 width=282) (actual time=0
-- .006..4.326 rows=29987 loops=1)
--          ->  Sort  (cost=808.78..812.75 rows=1589 width=4) (actual time=0.912..0.971 rows=1581 loops=1)
--                Sort Key: sessions.movie_id
--                Sort Method: quicksort  Memory: 49kB
--                ->  Bitmap Heap Scan on sessions  (cost=36.59..724.29 rows=1589 width=4) (actual time=0.179..0.
-- 777 rows=1581 loops=1)
--                      Recheck Cond: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:
-- 59'))::timestamp without time zone))
--                      Heap Blocks: exact=592
--                      ->  Bitmap Index Scan on idx_sessions_datetime  (cost=0.00..36.20 rows=1589 width=0) (act
-- ual time=0.128..0.128 rows=1581 loops=1)
--                            Index Cond: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23
-- :59:59'))::timestamp without time zone))
--  Planning Time: 0.300 ms
--  Execution Time: 7.766 ms