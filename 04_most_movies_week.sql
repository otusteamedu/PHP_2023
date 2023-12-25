-- Поиск 3 самых прибыльных фильмов за неделю

EXPLAIN ANALYZE
WITH start_day_week AS
(
SELECT
	date_trunc('week',
	current_date))

SELECT
	m.title AS "Название фильма",
	SUM(t.price) AS Сумма
FROM
	movies m
INNER JOIN seances s 
ON
	m.movie_id = s.movie_id
INNER JOIN tickets t
ON
	s.seance_id = t.seance_id
WHERE
	s.start_date >= (
	SELECT
		*
	FROM
		start_day_week)::date
	AND s.start_date <= (
	SELECT
		*
	FROM
		start_day_week)::date + INTERVAL '7 days'
GROUP BY
	m.title
ORDER BY Сумма DESC
LIMIT 3

--QUERY PLAN                                                                                                                                            |
--------------------------------------------------------------------------------------------------------------------------------------------------------+
--Limit  (cost=782.13..782.13 rows=3 width=43) (actual time=11.772..11.777 rows=3 loops=1)                                                              |
--  CTE start_day_week                                                                                                                                  |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)                                                            |
--  InitPlan 2 (returns $1)                                                                                                                             |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8) (actual time=0.007..0.007 rows=1 loops=1)                                        |
--  InitPlan 3 (returns $2)                                                                                                                             |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8) (actual time=0.000..0.001 rows=1 loops=1)                       |
--  ->  Sort  (cost=782.07..782.19 rows=50 width=43) (actual time=11.771..11.773 rows=3 loops=1)                                                        |
--        Sort Key: (sum(t.price)) DESC                                                                                                                 |
--        Sort Method: top-N heapsort  Memory: 25kB                                                                                                     |
--        ->  GroupAggregate  (cost=780.42..781.42 rows=50 width=43) (actual time=10.032..11.424 rows=1904 loops=1)                                     |
--              Group Key: m.title                                                                                                                      |
--              ->  Sort  (cost=780.42..780.55 rows=50 width=16) (actual time=10.020..10.171 rows=3290 loops=1)                                         |
--                    Sort Key: m.title                                                                                                                 |
--                    Sort Method: quicksort  Memory: 225kB                                                                                             |
--                    ->  Nested Loop  (cost=299.91..779.01 rows=50 width=16) (actual time=2.761..7.329 rows=3290 loops=1)                              |
--                          ->  Hash Join  (cost=299.62..499.89 rows=50 width=9) (actual time=2.749..4.318 rows=3290 loops=1)                           |
--                                Hash Cond: (t.seance_id = s.seance_id)                                                                                |
--                                ->  Seq Scan on tickets t  (cost=0.00..174.00 rows=10000 width=9) (actual time=0.005..0.433 rows=10000 loops=1)       |
--                                ->  Hash  (cost=299.00..299.00 rows=50 width=8) (actual time=2.736..2.737 rows=3219 loops=1)                          |
--                                      Buckets: 4096 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 158kB                                 |
--                                      ->  Seq Scan on seances s  (cost=0.00..299.00 rows=50 width=8) (actual time=0.013..2.261 rows=3219 loops=1)     |
--                                            Filter: ((start_time >= ($1)::date) AND (start_time <= (($2)::date + '7 days'::interval)))                |
--                                            Rows Removed by Filter: 6781                                                                              |
--                          ->  Index Scan using movies_pkey on movies m  (cost=0.29..5.58 rows=1 width=15) (actual time=0.001..0.001 rows=1 loops=3290)|
--                                Index Cond: (movie_id = s.movie_id)                                                                                   |
--Planning Time: 0.293 ms                                                                                                                               |
--Execution Time: 11.816 ms                                                                                                                             |

-- Добавляем индекс
CREATE INDEX start_time_index ON seances (start_date);

--QUERY PLAN                                                                                                                                                           |
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------+
--Limit  (cost=559.36..559.37 rows=3 width=43) (actual time=8.375..8.381 rows=3 loops=1)                                                                               |
--  CTE start_day_week                                                                                                                                                 |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)                                                                           |
--  InitPlan 2 (returns $1)                                                                                                                                            |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8) (actual time=0.006..0.007 rows=1 loops=1)                                                       |
--  InitPlan 3 (returns $2)                                                                                                                                            |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8) (actual time=0.000..0.001 rows=1 loops=1)                                      |
--  ->  Sort  (cost=559.31..559.43 rows=50 width=43) (actual time=8.374..8.377 rows=3 loops=1)                                                                         |
--        Sort Key: (sum(t.price)) DESC                                                                                                                                |
--        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                    |
--        ->  GroupAggregate  (cost=557.66..558.66 rows=50 width=43) (actual time=7.034..8.126 rows=1784 loops=1)                                                      |
--              Group Key: m.title                                                                                                                                     |
--              ->  Sort  (cost=557.66..557.79 rows=50 width=16) (actual time=7.024..7.135 rows=3123 loops=1)                                                          |
--                    Sort Key: m.title                                                                                                                                |
--                    Sort Method: quicksort  Memory: 218kB                                                                                                            |
--                    ->  Nested Loop  (cost=77.15..556.25 rows=50 width=16) (actual time=0.839..4.657 rows=3123 loops=1)                                              |
--                          ->  Hash Join  (cost=76.86..277.12 rows=50 width=9) (actual time=0.828..2.162 rows=3123 loops=1)                                           |
--                                Hash Cond: (t.seance_id = s.seance_id)                                                                                               |
--                                ->  Seq Scan on tickets t  (cost=0.00..174.00 rows=10000 width=9) (actual time=0.004..0.393 rows=10000 loops=1)                      |
--                                ->  Hash  (cost=76.24..76.24 rows=50 width=8) (actual time=0.819..0.821 rows=3090 loops=1)                                           |
--                                      Buckets: 4096 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 153kB                                                |
--                                      ->  Bitmap Heap Scan on seances s  (cost=4.81..76.24 rows=50 width=8) (actual time=0.108..0.501 rows=3090 loops=1)             |
--                                            Recheck Cond: ((start_date >= ($1)::date) AND (start_date <= (($2)::date + '7 days'::interval)))                         |
--                                            Heap Blocks: exact=74                                                                                                    |
--                                            ->  Bitmap Index Scan on start_time_index  (cost=0.00..4.79 rows=50 width=0) (actual time=0.092..0.092 rows=3090 loops=1)|
--                                                  Index Cond: ((start_date >= ($1)::date) AND (start_date <= (($2)::date + '7 days'::interval)))                     |
--                          ->  Index Scan using movies_pkey on movies m  (cost=0.29..5.58 rows=1 width=15) (actual time=0.001..0.001 rows=1 loops=3123)               |
--                                Index Cond: (movie_id = s.movie_id)                                                                                                  |
--Planning Time: 0.306 ms                                                                                                                                              |
--Execution Time: 8.428 ms                                                                                                                                             |
                                                              |