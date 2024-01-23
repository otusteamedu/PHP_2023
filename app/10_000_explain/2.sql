-- Подсчёт проданных билетов за неделю
explain analyse
select
    count(*)
from
    ticket
where
    created_at between (CURRENT_DATE - INTERVAL '7 day') and CURRENT_DATE;

-- QUERY PLAN
-- Aggregate  (cost=299.00..299.01 rows=1 width=8) (actual time=0.944..0.945 rows=1 loops=1)
--   ->  Seq Scan on ticket  (cost=0.00..299.00 rows=1 width=0) (actual time=0.941..0.942 rows=0 loops=1)
--         Filter: ((created_at <= CURRENT_DATE) AND (created_at >= (CURRENT_DATE - '7 days'::interval)))
--         Rows Removed by Filter: 10000
-- Planning Time: 0.164 ms
-- Execution Time: 0.960 ms


-- Добавляем индекс для таблицы ticket по дате продажи
CREATE INDEX idx_ticket_created_at ON ticket(created_at);

-- QUERY PLAN
-- Aggregate  (cost=4.32..4.33 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)
--   ->  Index Only Scan using idx_ticket_created_at on ticket  (cost=0.29..4.31 rows=1 width=0) (actual time=0.003..0.003 rows=0 loops=1)
--         Index Cond: ((created_at >= (CURRENT_DATE - '7 days'::interval)) AND (created_at <= CURRENT_DATE))
--         Heap Fetches: 0
-- Planning Time: 0.180 ms
-- Execution Time: 0.018 ms


-- По результату анализа запроса можно сказать следующее:
--  добавление индекса на порядки снизело стоимость и время выполнения запроса

-- Вывод: применение индекса оправданно
