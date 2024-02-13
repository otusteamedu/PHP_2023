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
		
	
--QUERY PLAN                                                                                                                               |
-----------------------------------------------------------------------------------------------------------------------------------------+
--Finalize Aggregate  (cost=17733.48..17733.49 rows=1 width=8) (actual time=142.824..158.815 rows=1 loops=1)                               |
--  CTE start_day_week                                                                                                                     |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8) (actual time=0.074..0.075 rows=1 loops=1)                                               |
--  InitPlan 2 (returns $1)                                                                                                                |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8) (actual time=0.077..0.078 rows=1 loops=1)                           |
--  InitPlan 3 (returns $2)                                                                                                                |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8) (actual time=0.000..0.001 rows=1 loops=1)          |
--  ->  Gather  (cost=17733.21..17733.42 rows=2 width=8) (actual time=142.383..158.805 rows=3 loops=1)                                     |
--        Workers Planned: 2                                                                                                               |
--        Params Evaluated: $1, $2                                                                                                         |
--        Workers Launched: 2                                                                                                              |
--        ->  Partial Aggregate  (cost=16733.21..16733.22 rows=1 width=8) (actual time=127.013..127.014 rows=1 loops=3)                    |
--              ->  Parallel Seq Scan on tickets t  (cost=0.00..16728.00 rows=2083 width=0) (actual time=0.053..123.908 rows=43592 loops=3)|
--                    Filter: ((purchased_date >= ($1)::date) AND (purchased_date <= (($2)::date + '7 days'::interval)))                   |
--                    Rows Removed by Filter: 289741                                                                                       |
--Planning Time: 1.533 ms                                                                                                                  |
--Execution Time: 158.918 ms                                                                                                               |

	
CREATE INDEX purchased_date_index ON tickets (purchased_date);

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
		

	
--	QUERY PLAN                                                                                                                                         |
---------------------------------------------------------------------------------------------------------------------------------------------------+
-- Aggregate  (cost=132.99..133.00 rows=1 width=8) (actual time=14.255..14.257 rows=1 loops=1)                                                        |
--  CTE start_day_week                                                                                                                               |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)                                                         |
--  InitPlan 2 (returns $1)                                                                                                                          |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8) (actual time=0.006..0.006 rows=1 loops=1)                                     |
--  InitPlan 3 (returns $2)                                                                                                                          |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=1)                    |
--  ->  Index Only Scan using purchased_date_index on tickets t  (cost=0.43..120.43 rows=5000 width=0) (actual time=0.278..8.246 rows=130776 loops=1)|
--        Index Cond: ((purchased_date >= ($1)::date) AND (purchased_date <= (($2)::date + '7 days'::interval)))                                     |
--        Heap Fetches: 0                                                                                                                            |
--Planning Time: 0.956 ms                                                                                                                            |
--Execution Time: 14.278 ms                                                                                                                          |