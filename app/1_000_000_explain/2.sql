-- Подсчёт проданных билетов за неделю
explain analyse
select
    count(*)
from
    ticket
where
    created_at between (CURRENT_DATE - INTERVAL '7 day') and CURRENT_DATE;

-- QUERY PLAN
-- Aggregate  (cost=17728.10..17728.11 rows=1 width=8) (actual time=42.912..49.259 rows=1 loops=1)
--   ->  Gather  (cost=1000.00..17728.10 rows=1 width=0) (actual time=42.909..49.255 rows=0 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Parallel Seq Scan on ticket  (cost=0.00..16728.00 rows=1 width=0) (actual time=32.239..32.240 rows=0 loops=3)
--               Filter: ((created_at <= CURRENT_DATE) AND (created_at >= (CURRENT_DATE - '7 days'::interval)))
--               Rows Removed by Filter: 333333
-- Planning Time: 0.099 ms
-- Execution Time: 49.274 ms


-- Добавляем индекс для таблицы ticket по дате продажи
CREATE INDEX idx_ticket_created_at ON ticket(created_at);

-- QUERY PLAN
-- Aggregate  (cost=4.46..4.46 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)
--   ->  Index Only Scan using idx_ticket_created_at on ticket  (cost=0.43..4.45 rows=1 width=0) (actual time=0.003..0.004 rows=0 loops=1)
--         Index Cond: ((created_at >= (CURRENT_DATE - '7 days'::interval)) AND (created_at <= CURRENT_DATE))
--         Heap Fetches: 0
-- Planning Time: 0.142 ms
-- Execution Time: 0.018 ms



-- По результату анализа запроса можно сказать следующее:
-- добавление индекса на порядки снизело стоимость и время выполнения запроса (особенно на большом количестве данных).
-- Фактически при использовании индекса на 10 000 строках и на 1 000 000 строк время выполнения скрипта не поменялось

-- Вывод: применение индекса оправданно
