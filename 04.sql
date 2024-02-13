-- Поиск 3 самых прибыльных фильмов за неделю
DROP INDEX start_date_index;


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
	(s.start_time  >= (
	SELECT
		*
	FROM
		start_day_week)::date
	AND s.start_time <= (
	SELECT
		*
	FROM
		start_day_week)::date + INTERVAL '7 days')
	AND t.payment_flag = true
GROUP BY
	m.title
ORDER BY Сумма DESC
LIMIT 3;


--QUERY PLAN                                                                                                                                                               |
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
--Limit  (cost=14123.28..14123.29 rows=3 width=43) (actual time=150.936..152.414 rows=3 loops=1)                                                                           |
--  CTE start_day_week                                                                                                                                                     |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8) (actual time=0.070..0.070 rows=1 loops=1)                                                                               |
--  InitPlan 2 (returns $1)                                                                                                                                                |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8) (actual time=0.074..0.075 rows=1 loops=1)                                                           |
--  InitPlan 3 (returns $2)                                                                                                                                                |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8) (actual time=0.000..0.001 rows=1 loops=1)                                          |
--  ->  Sort  (cost=14123.23..14129.43 rows=2480 width=43) (actual time=150.935..152.411 rows=3 loops=1)                                                                   |
--        Sort Key: (sum(t.price)) DESC                                                                                                                                    |
--        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                        |
--        ->  Finalize GroupAggregate  (cost=13785.55..14091.17 rows=2480 width=43) (actual time=144.754..152.125 rows=1225 loops=1)                                       |
--              Group Key: m.title                                                                                                                                         |
--              ->  Gather Merge  (cost=13785.55..14044.68 rows=2066 width=43) (actual time=144.746..151.056 rows=3675 loops=1)                                            |
--                    Workers Planned: 2                                                                                                                                   |
--                    Params Evaluated: $1, $2                                                                                                                             |
--                    Workers Launched: 2                                                                                                                                  |
--                    ->  Partial GroupAggregate  (cost=12785.53..12806.19 rows=1033 width=43) (actual time=115.474..119.100 rows=1225 loops=3)                            |
--                          Group Key: m.title                                                                                                                             |
--                          ->  Sort  (cost=12785.53..12788.11 rows=1033 width=16) (actual time=115.456..116.396 rows=21779 loops=3)                                       |
--                                Sort Key: m.title                                                                                                                        |
--                                Sort Method: quicksort  Memory: 1703kB                                                                                                   |
--                                Worker 0:  Sort Method: quicksort  Memory: 1576kB                                                                                        |
--                                Worker 1:  Sort Method: quicksort  Memory: 1579kB                                                                                        |
--                                ->  Hash Join  (cost=668.62..12733.81 rows=1033 width=16) (actual time=15.684..96.508 rows=21779 loops=3)                                |
--                                      Hash Cond: (s.movie_id = m.movie_id)                                                                                               |
--                                      ->  Hash Join  (cost=359.63..12422.10 rows=1033 width=9) (actual time=4.958..78.980 rows=21779 loops=3)                            |
--                                            Hash Cond: (t.seance_id = s.seance_id)                                                                                       |
--                                            ->  Parallel Seq Scan on tickets t  (cost=0.00..11519.67 rows=206695 width=9) (actual time=0.120..58.823 rows=166767 loops=3)|
--                                                  Filter: payment_flag                                                                                                   |
--                                                  Rows Removed by Filter: 166566                                                                                         |
--                                            ->  Hash  (cost=359.00..359.00 rows=50 width=8) (actual time=4.666..4.667 rows=1304 loops=3)                                 |
--                                                  Buckets: 2048 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 67kB                                         |
--                                                  ->  Seq Scan on seances s  (cost=0.00..359.00 rows=50 width=8) (actual time=0.164..3.329 rows=1304 loops=3)            |
--                                                        Filter: ((date(start_time) >= ($1)::date) AND (date(start_time) <= (($2)::date + '7 days'::interval)))           |
--                                                        Rows Removed by Filter: 8696                                                                                     |
--                                      ->  Hash  (cost=184.00..184.00 rows=10000 width=15) (actual time=10.260..10.261 rows=10000 loops=3)                                |
--                                            Buckets: 16384  Batches: 1  Memory Usage: 597kB                                                                              |
--                                            ->  Seq Scan on movies m  (cost=0.00..184.00 rows=10000 width=15) (actual time=0.159..3.259 rows=10000 loops=3)              |
--Planning Time: 7.088 ms                                                                                                                                                  |
--Execution Time: 153.221 ms                                                                                                                                               |

CREATE INDEX start_date_index ON seances (start_time);


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
	(s.start_time  >= (
	SELECT
		*
	FROM
		start_day_week)::date
	AND s.start_time <= (
	SELECT
		*
	FROM
		start_day_week)::date + INTERVAL '7 days')
	AND t.payment_flag = true
GROUP BY
	m.title
ORDER BY Сумма DESC
LIMIT 3;

--QUERY PLAN                                                                                                                                                                       |
---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
--Limit  (cost=13846.49..13846.50 rows=3 width=43) (actual time=62.678..62.998 rows=3 loops=1)                                                                                     |
--  CTE start_day_week                                                                                                                                                             |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8) (actual time=0.004..0.004 rows=1 loops=1)                                                                                       |
--  InitPlan 2 (returns $1)                                                                                                                                                        |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)                                                                   |
--  InitPlan 3 (returns $2)                                                                                                                                                        |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=1)                                                  |
--  ->  Sort  (cost=13846.43..13852.63 rows=2480 width=43) (actual time=62.677..62.994 rows=3 loops=1)                                                                             |
--        Sort Key: (sum(t.price)) DESC                                                                                                                                            |
--        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                                |
--        ->  Finalize GroupAggregate  (cost=13508.76..13814.38 rows=2480 width=43) (actual time=56.738..62.845 rows=1225 loops=1)                                                 |
--              Group Key: m.title                                                                                                                                                 |
--              ->  Gather Merge  (cost=13508.76..13767.89 rows=2066 width=43) (actual time=56.730..61.916 rows=3675 loops=1)                                                      |
--                    Workers Planned: 2                                                                                                                                           |
--                    Params Evaluated: $1, $2                                                                                                                                     |
--                    Workers Launched: 2                                                                                                                                          |
--                    ->  Partial GroupAggregate  (cost=12508.73..12529.39 rows=1033 width=43) (actual time=51.110..54.754 rows=1225 loops=3)                                      |
--                          Group Key: m.title                                                                                                                                     |
--                          ->  Sort  (cost=12508.73..12511.32 rows=1033 width=16) (actual time=51.097..52.102 rows=21779 loops=3)                                                 |
--                                Sort Key: m.title                                                                                                                                |
--                                Sort Method: quicksort  Memory: 1737kB                                                                                                           |
--                                Worker 0:  Sort Method: quicksort  Memory: 1567kB                                                                                                |
--                                Worker 1:  Sort Method: quicksort  Memory: 1553kB                                                                                                |
--                                ->  Hash Join  (cost=391.83..12457.02 rows=1033 width=16) (actual time=2.493..36.921 rows=21779 loops=3)                                         |
--                                      Hash Cond: (s.movie_id = m.movie_id)                                                                                                       |
--                                      ->  Hash Join  (cost=82.83..12145.31 rows=1033 width=9) (actual time=0.692..31.374 rows=21779 loops=3)                                     |
--                                            Hash Cond: (t.seance_id = s.seance_id)                                                                                               |
--                                            ->  Parallel Seq Scan on tickets t  (cost=0.00..11519.67 rows=206695 width=9) (actual time=0.006..19.873 rows=166767 loops=3)        |
--                                                  Filter: payment_flag                                                                                                           |
--                                                  Rows Removed by Filter: 166566                                                                                                 |
--                                            ->  Hash  (cost=82.21..82.21 rows=50 width=8) (actual time=0.666..0.667 rows=1304 loops=3)                                           |
--                                                  Buckets: 2048 (originally 1024)  Batches: 1 (originally 1)  Memory Usage: 67kB                                                 |
--                                                  ->  Bitmap Heap Scan on seances s  (cost=4.81..82.21 rows=50 width=8) (actual time=0.113..0.435 rows=1304 loops=3)             |
--                                                        Recheck Cond: ((start_time >= ($1)::date) AND (start_time <= (($2)::date + '7 days'::interval)))                         |
--                                                        Heap Blocks: exact=84                                                                                                    |
--                                                        ->  Bitmap Index Scan on start_time_index  (cost=0.00..4.79 rows=50 width=0) (actual time=0.102..0.102 rows=1304 loops=3)|
--                                                              Index Cond: ((start_time >= ($1)::date) AND (start_time <= (($2)::date + '7 days'::interval)))                     |
--                                      ->  Hash  (cost=184.00..184.00 rows=10000 width=15) (actual time=1.760..1.761 rows=10000 loops=3)                                          |
--                                            Buckets: 16384  Batches: 1  Memory Usage: 597kB                                                                                      |
--                                            ->  Seq Scan on movies m  (cost=0.00..184.00 rows=10000 width=15) (actual time=0.071..0.748 rows=10000 loops=3)                      |
--Planning Time: 0.607 ms                                                                                                                                                          |
--Execution Time: 63.160 ms                                                                                                                                                        |