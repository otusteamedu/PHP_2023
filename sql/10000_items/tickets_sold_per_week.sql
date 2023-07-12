explain analyse SELECT COUNT(id) AS ticket_count
FROM tickets WHERE tickets.sold_date >= CURRENT_DATE - INTERVAL '7 days' AND sold_date < CURRENT_DATE;

-- Резульат:
-- Aggregate  (cost=79.13..79.14 rows=1 width=8) (actual time=0.449..0.454 rows=1 loops=1)
--   ->  Seq Scan on tickets  (cost=0.00..79.08 rows=20 width=4) (actual time=0.011..0.415 rows=24 loops=1)
--         Filter: ((sold_date < CURRENT_DATE) AND (sold_date >= (CURRENT_DATE - '7 days'::interval)))
--         Rows Removed by Filter: 2513
-- Planning Time: 0.076 ms
-- Execution Time: 0.475 ms


-- Индекс на столбец sold_date в таблице tickets.
CREATE INDEX idx_sold_date ON tickets (sold_date);

explain analyse SELECT COUNT(id) AS ticket_count
FROM tickets WHERE tickets.sold_date >= CURRENT_DATE - INTERVAL '7 days' AND sold_date < CURRENT_DATE;

-- Результат после приминения индексов:
-- Aggregate  (cost=27.49..27.50 rows=1 width=8) (actual time=0.202..0.211 rows=1 loops=1)
--   ->  Bitmap Heap Scan on tickets  (cost=4.49..27.44 rows=20 width=4) (actual time=0.035..0.096 rows=24 loops=1)
--         Recheck Cond: ((sold_date >= (CURRENT_DATE - '7 days'::interval)) AND (sold_date < CURRENT_DATE))
--         Heap Blocks: exact=15
--         ->  Bitmap Index Scan on idx_sold_date  (cost=0.00..4.49 rows=20 width=0) (actual time=0.025..0.027 rows=24 loops=1)
--               Index Cond: ((sold_date >= (CURRENT_DATE - '7 days'::interval)) AND (sold_date < CURRENT_DATE))
-- Planning Time: 0.246 ms
-- Execution Time: 0.247 ms


-- Вывод: Индексы повлияли на производительность запроса положительно.
