explain analyse SELECT COUNT(id) AS ticket_count
FROM tickets WHERE tickets.sold_date >= CURRENT_DATE - INTERVAL '7 days' AND sold_date < CURRENT_DATE;

-- Резульат:
-- Aggregate  (cost=198.24..198.25 rows=1 width=8) (actual time=2.197..2.205 rows=1 loops=1)
--   ->  Seq Scan on tickets  (cost=0.00..198.16 rows=34 width=4) (actual time=0.036..2.147 rows=24 loops=1)
--         Filter: ((sold_date < CURRENT_DATE) AND (sold_date >= (CURRENT_DATE - '7 days'::interval)))
--         Rows Removed by Filter: 6383
-- Planning Time: 0.262 ms
-- Execution Time: 2.242 ms


-- Индекс на столбец sold_date в таблице tickets.
CREATE INDEX idx_sold_date ON tickets (sold_date);

explain analyse SELECT COUNT(id) AS ticket_count
FROM tickets WHERE tickets.sold_date >= CURRENT_DATE - INTERVAL '7 days' AND sold_date < CURRENT_DATE;

-- Результат после приминения индексов:
-- Aggregate  (cost=55.37..55.38 rows=1 width=8) (actual time=0.202..0.214 rows=1 loops=1)
--   ->  Bitmap Heap Scan on tickets  (cost=4.64..55.28 rows=34 width=4) (actual time=0.040..0.149 rows=24 loops=1)
--         Recheck Cond: ((sold_date >= (CURRENT_DATE - '7 days'::interval)) AND (sold_date < CURRENT_DATE))
--         Heap Blocks: exact=22
--         ->  Bitmap Index Scan on idx_sold_date  (cost=0.00..4.63 rows=34 width=0) (actual time=0.021..0.024 rows=24 loops=1)
--               Index Cond: ((sold_date >= (CURRENT_DATE - '7 days'::interval)) AND (sold_date < CURRENT_DATE))
-- Planning Time: 0.461 ms
-- Execution Time: 0.277 ms


-- Вывод: Индексы повлияли на производительность запроса положительно.
