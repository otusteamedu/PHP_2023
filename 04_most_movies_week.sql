-- Поиск 3 самых прибыльных фильмов за неделю

EXPLAIN
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

--QUERY PLAN                                                                                                                            |
----------------------------------------------------------------------------------------------------------------------------------------+
--Limit  (cost=782.13..782.13 rows=3 width=43)                                                                                          |
--  CTE start_day_week                                                                                                                  |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8)                                                                                      |
--  InitPlan 2 (returns $1)                                                                                                             |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8)                                                                  |
--  InitPlan 3 (returns $2)                                                                                                             |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8)                                                 |
--  ->  Sort  (cost=782.07..782.19 rows=50 width=43)                                                                                    |
--        Sort Key: (sum(t.price)) DESC                                                                                                 |
--        ->  GroupAggregate  (cost=780.42..781.42 rows=50 width=43)                                                                    |
--              Group Key: m.title                                                                                                      |
--              ->  Sort  (cost=780.42..780.55 rows=50 width=16)                                                                        |
--                    Sort Key: m.title                                                                                                 |
--                    ->  Nested Loop  (cost=299.91..779.01 rows=50 width=16)                                                           |
--                          ->  Hash Join  (cost=299.62..499.89 rows=50 width=9)                                                        |
--                                Hash Cond: (t.seance_id = s.seance_id)                                                                |
--                                ->  Seq Scan on tickets t  (cost=0.00..174.00 rows=10000 width=9)                                     |
--                                ->  Hash  (cost=299.00..299.00 rows=50 width=8)                                                       |
--                                      ->  Seq Scan on seances s  (cost=0.00..299.00 rows=50 width=8)                                  |
--                                            Filter: ((start_date >= ($1)::date) AND (start_date <= (($2)::date + '7 days'::interval)))|
--                          ->  Index Scan using movies_pkey on movies m  (cost=0.29..5.58 rows=1 width=15)                             |
--                                Index Cond: (movie_id = s.movie_id)                                                                   |

-- Добавляем индекс (был добавлен ранее, предыдщий запрос без него)
CREATE INDEX start_time_index ON seances (start_date);

--QUERY PLAN                                                                                                                                      |
--------------------------------------------------------------------------------------------------------------------------------------------------+
--Limit  (cost=559.36..559.37 rows=3 width=43)                                                                                                    |
--  CTE start_day_week                                                                                                                            |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8)                                                                                                |
--  InitPlan 2 (returns $1)                                                                                                                       |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8)                                                                            |
--  InitPlan 3 (returns $2)                                                                                                                       |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8)                                                           |
--  ->  Sort  (cost=559.31..559.43 rows=50 width=43)                                                                                              |
--        Sort Key: (sum(t.price)) DESC                                                                                                           |
--        ->  GroupAggregate  (cost=557.66..558.66 rows=50 width=43)                                                                              |
--              Group Key: m.title                                                                                                                |
--              ->  Sort  (cost=557.66..557.79 rows=50 width=16)                                                                                  |
--                    Sort Key: m.title                                                                                                           |
--                    ->  Nested Loop  (cost=77.15..556.25 rows=50 width=16)                                                                      |
--                          ->  Hash Join  (cost=76.86..277.12 rows=50 width=9)                                                                   |
--                                Hash Cond: (t.seance_id = s.seance_id)                                                                          |
--                                ->  Seq Scan on tickets t  (cost=0.00..174.00 rows=10000 width=9)                                               |
--                                ->  Hash  (cost=76.24..76.24 rows=50 width=8)                                                                   |
--                                      ->  Bitmap Heap Scan on seances s  (cost=4.81..76.24 rows=50 width=8)                                     |
--                                            Recheck Cond: ((start_date >= ($1)::date) AND (start_date <= (($2)::date + '7 days'::interval)))    |
--                                            ->  Bitmap Index Scan on start_time_index  (cost=0.00..4.79 rows=50 width=0)                        |
--                                                  Index Cond: ((start_date >= ($1)::date) AND (start_date <= (($2)::date + '7 days'::interval)))|
--                          ->  Index Scan using movies_pkey on movies m  (cost=0.29..5.58 rows=1 width=15)                                       |
--                                Index Cond: (movie_id = s.movie_id)                                                                             |