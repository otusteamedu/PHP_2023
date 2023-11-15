--Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN ANALYSE
SELECT
    min(p.price) as min_price,
    max(p.price) as max_price
FROM
    prices as p
WHERE
    session_id = 1;

-- Aggregate  (cost=189.04..189.05 rows=1 width=16) (actual time=1.330..1.331 rows=1 loops=1)
--   ->  Seq Scan on prices p  (cost=0.00..189.00 rows=9 width=8) (actual time=0.091..1.320 rows=9 loops=1)
--         Filter: (session_id = 1)
--         Rows Removed by Filter: 9991
-- Planning Time: 0.217 ms
-- Execution Time: 1.366 ms

create index idx_price ON prices(price);

-- Result  (cost=112.57..112.58 rows=1 width=16) (actual time=1.605..1.607 rows=1 loops=1)
--   InitPlan 1 (returns $0)
--     ->  Limit  (cost=0.29..56.28 rows=1 width=8) (actual time=0.842..0.843 rows=1 loops=1)
--           ->  Index Scan using idx_price on prices p  (cost=0.29..504.28 rows=9 width=8) (actual time=0.840..0.841 rows=1 loops=1)
--                 Index Cond: (price IS NOT NULL)
--                 Filter: (session_id = 1)
--                 Rows Removed by Filter: 1205
--   InitPlan 2 (returns $1)
--     ->  Limit  (cost=0.29..56.28 rows=1 width=8) (actual time=0.755..0.756 rows=1 loops=1)
--           ->  Index Scan Backward using idx_price on prices p_1  (cost=0.29..504.28 rows=9 width=8) (actual time=0.755..0.755 rows=1 loops=1)
--                 Index Cond: (price IS NOT NULL)
--                 Filter: (session_id = 1)
--                 Rows Removed by Filter: 1113
-- Planning Time: 0.205 ms
-- Execution Time: 1.644 ms

--Анализ показал, что добавление индекса на поле price практически не изменило стоимость получения первой строки, но время выполнения запроса увеличилось
--Вывод: добавление индекса не оправдано
