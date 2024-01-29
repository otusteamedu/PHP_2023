
EXPLAIN ANALYSE
SELECT DISTINCT movies.name
FROM
    sessions LEFT JOIN movies ON movies.id = sessions.movie_id
WHERE
    sessions.datetime BETWEEN current_date AND concat(CURRENT_DATE, ' 23:59:59')::timestamp;

--Unique  (cost=613.28..613.37 rows=18 width=273) (actual time=2.431..2.436 rows=1 loops=1)
--  ->  Sort  (cost=613.28..613.33 rows=18 width=273) (actual time=2.429..2.432 rows=18 loops=1)
--        Sort Key: movies.name
--       Sort Method: quicksort  Memory: 25kB
--        ->  Hash Right Join  (cost=34.73..612.90 rows=18 width=273) (actual time=2.421..2.425 rows=18 loops=1)
--             Hash Cond: (movies.id = sessions.movie_id)
--              ->  Seq Scan on movies  (cost=0.00..503.00 rows=10000 width=277) (actual time=0.003..0.849 rows=10000 loops=1)
--              ->  Hash  (cost=34.50..34.50 rows=18 width=4) (actual time=0.158..0.159 rows=18 loops=1)
--                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                    ->  Seq Scan on sessions  (cost=0.00..34.50 rows=18 width=4) (actual time=0.023..0.153 rows=18 loops=1)
--"                          Filter: ((datetime >= CURRENT_DATE) AND (datetime <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                          Rows Removed by Filter: 982
--Planning Time: 0.131 ms
--Execution Time: 2.458 ms


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