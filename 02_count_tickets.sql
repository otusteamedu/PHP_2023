-- Количество проданных билетов за неделю

EXPLAIN
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
	purchased_time::date >= (
	SELECT
		*
	FROM
		start_day_week)::date
	AND purchased_time::date <= (
	SELECT
		*
	FROM
		start_day_week)::date + INTERVAL '7 days';
		
--QUERY PLAN                                                                                                                |
----------------------------------------------------------------------------------------------------------------------------+
--Aggregate  (cost=349.18..349.19 rows=1 width=8)                                                                           |
--  CTE start_day_week                                                                                                      |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8)                                                                          |
--  InitPlan 2 (returns $1)                                                                                                 |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8)                                                      |
--  InitPlan 3 (returns $2)                                                                                                 |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8)                                     |
--  ->  Seq Scan on tickets t  (cost=0.00..349.00 rows=50 width=0)                                                          |
--        Filter: (((purchased_time)::date >= ($1)::date) AND ((purchased_time)::date <= (($2)::date + '7 days'::interval)))|
		
-- Создаем индекс	
CREATE INDEX purchased_time_index ON tickets (purchased_time);
	
--QUERY PLAN                                                                                                                |
----------------------------------------------------------------------------------------------------------------------------+
--Aggregate  (cost=349.18..349.19 rows=1 width=8)                                                                           |
--  CTE start_day_week                                                                                                      |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8)                                                                          |
--  InitPlan 2 (returns $1)                                                                                                 |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8)                                                      |
--  InitPlan 3 (returns $2)                                                                                                 |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8)                                     |
--  ->  Seq Scan on tickets t  (cost=0.00..349.00 rows=50 width=0)                                                          |
--        Filter: (((purchased_time)::date >= ($1)::date) AND ((purchased_time)::date <= (($2)::date + '7 days'::interval)))|
	
-- Улучшений нет. Меняем структуру БД. Отдельно храним дату и время
-- Создаем индекс	
CREATE INDEX purchased_time_index ON tickets (purchased_date);
	
EXPLAIN
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
	
--QUERY PLAN                                                                                                    |
----------------------------------------------------------------------------------------------------------------+
--Aggregate  (cost=5.48..5.49 rows=1 width=8)                                                                   |
--  CTE start_day_week                                                                                          |
--    ->  Result  (cost=0.00..0.02 rows=1 width=8)                                                              |
--  InitPlan 2 (returns $1)                                                                                     |
--    ->  CTE Scan on start_day_week  (cost=0.00..0.02 rows=1 width=8)                                          |
--  InitPlan 3 (returns $2)                                                                                     |
--    ->  CTE Scan on start_day_week start_day_week_1  (cost=0.00..0.02 rows=1 width=8)                         |
--  ->  Index Only Scan using purchased_time_index on tickets t  (cost=0.29..5.29 rows=50 width=0)              |
--        Index Cond: ((purchased_date >= ($1)::date) AND (purchased_date <= (($2)::date + '7 days'::interval)))|
        
        