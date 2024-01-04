
EXPLAIN ANALYSE
SELECT DISTINCT movies.name
FROM
    sessions LEFT JOIN movies ON movies.id = sessions.movie_id
WHERE
    sessions.datetime BETWEEN current_date AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;

-- Unique  (cost=42.81..42.82 rows=1 width=278) (actual time=0.080..0.080 rows=0 loops=1)
--    ->  Sort  (cost=42.81..42.82 rows=1 width=278) (actual time=0.079..0.080 rows=0 loops=1)
--          Sort Key: movies.name
--          Sort Method: quicksort  Memory: 25kB
--          ->  Nested Loop Left Join  (cost=0.29..42.80 rows=1 width=278) (actual time=0.072..0.072 rows=0 loops
-- =1)
--                ->  Seq Scan on sessions  (cost=0.00..34.50 rows=1 width=4) (actual time=0.071..0.072 rows=0 lo
-- ops=1)
--                      Filter: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59')):
-- :timestamp without time zone))
--                      Rows Removed by Filter: 1000
--                ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=282) (never executed)
--                      Index Cond: (id = sessions.movie_id)
--  Planning Time: 0.349 ms
--  Execution Time: 0.098 ms

-- create index --
create index idx_sessions_datetime on sessions(datetime);


-- Unique  (cost=16.62..16.63 rows=1 width=278) (actual time=0.017..0.018 rows=0 loops=1)
--    ->  Sort  (cost=16.62..16.63 rows=1 width=278) (actual time=0.017..0.017 rows=0 loops=1)
--          Sort Key: movies.name
--          Sort Method: quicksort  Memory: 25kB
--          ->  Nested Loop Left Join  (cost=0.57..16.61 rows=1 width=278) (actual time=0.013..0.013 rows=0 loops
-- =1)
--                ->  Index Scan using idx_datetime on sessions  (cost=0.29..8.31 rows=1 width=4) (actual time=0.
-- 013..0.013 rows=0 loops=1)
--                      Index Cond: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59
-- '))::timestamp without time zone))
--                ->  Index Scan using movies_pkey on movies  (cost=0.29..8.30 rows=1 width=282) (never executed)
--                      Index Cond: (id = sessions.movie_id)
--  Planning Time: 0.303 ms
--  Execution Time: 0.033 ms