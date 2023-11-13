--Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN ANALYSE
SELECT
    min(p.price) as min_price,
    max(p.price) as max_price
FROM
    prices as p
WHERE
    session_id = 67645;

-- Aggregate  (cost=189.00..189.01 rows=1 width=16) (actual time=0.551..0.552 rows=1 loops=1)
--   ->  Seq Scan on prices p  (cost=0.00..189.00 rows=1 width=8) (actual time=0.008..0.549 rows=1 loops=1)
--         Filter: (session_id = 67645)
--         Rows Removed by Filter: 9999
-- Planning Time: 0.063 ms
-- Execution Time: 0.566 ms

create index idx_price ON prices(price);

-- Aggregate  (cost=189.00..189.01 rows=1 width=16) (actual time=0.559..0.559 rows=1 loops=1)
--   ->  Seq Scan on prices p  (cost=0.00..189.00 rows=1 width=8) (actual time=0.007..0.556 rows=1 loops=1)
--         Filter: (session_id = 67645)
--         Rows Removed by Filter: 9999
-- Planning Time: 0.083 ms
-- Execution Time: 0.573 ms

--Анализ показал, что добавление индекса не изменило время выполнения запроса
--Вывод: добавление индекса не оправдано