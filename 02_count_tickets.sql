-- Количество проданных билетов за неделю

EXPLAIN ANALYZE
WITH start_day_week AS
(
SELECT
	date_trunc('week',
	current_date))
	
SELECT
	COUNT(*) AS "Количество билетов"
FROM
	tickets t
WHERE
	purchased_date >= (
	SELECT
		*
	FROM
		start_day_week)::date
	AND purchased_date <= (
	SELECT
		*
	FROM
		start_day_week)::date + INTERVAL '7 days';

--QUERY PLAN                                                                                                                     |
---------------------------------------------------------------------------------------------------------------------------------+
--Aggregate  (cost=349.18..349.19 rows=1 width=8) (actual time=2.021..2.023 rows=1 loops=1)                                      |
--  CTE start_day_week                                                                                                           |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8) (actual time=0.007..0.008 rows=1 loops=1)                                     |
--  InitPlan 2 (returns $1)                                                                                                      |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8) (actual time=0.009..0.010 rows=1 loops=1)                 |
--  InitPlan 3 (returns $2)                                                                                                      |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8) (actual time=0.000..0.001 rows=1 loops=1)|
--  ->  Seq Scan on tickets t  (cost=0.00..349.00 rows=50 width=0) (actual time=0.030..1.899 rows=3177 loops=1)                  |
--        Filter: (((purchased_time)::date >= ($1)::date) AND ((purchased_time)::date <= (($2)::date + '7 days'::interval)))     |
--        Rows Removed by Filter: 6823                                                                                           |
--Planning Time: 0.076 ms                                                                                                        |
--Execution Time: 2.047 ms                                                                                                       |

--Меняем структуру БД. Отдельно храним дату и время
-- Создаем индекс	
CREATE INDEX purchased_time_index ON tickets (purchased_date);

--QUERY PLAN                                                                                                                                   |
-----------------------------------------------------------------------------------------------------------------------------------------------+
--Aggregate  (cost=5.48..5.49 rows=1 width=8) (actual time=1.424..1.425 rows=1 loops=1)                                                        |
--  CTE start_day_week                                                                                                                         |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)                                                   |
--  InitPlan 2 (returns $1)                                                                                                                    |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8) (actual time=0.006..0.007 rows=1 loops=1)                               |
--  InitPlan 3 (returns $2)                                                                                                                    |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=1)              |
--  ->  Index Only Scan using purchased_time_index on tickets t  (cost=0.29..5.29 rows=50 width=0) (actual time=0.849..1.305 rows=3198 loops=1)|
--        Index Cond: ((purchased_date >= ($1)::date) AND (purchased_date <= (($2)::date + '7 days'::interval)))                               |
--        Heap Fetches: 0                                                                                                                      |
--Planning Time: 1.121 ms                                                                                                                      |
--Execution Time: 1.454 ms                                                                                                                     |
