-- Подсчёт проданных билетов за неделю
explain analyse
    select
        count(*)
    from
        tickets
    where
        buyed_at::date between (current_date - INTERVAL '7 day') and current_date;

--         QUERY PLAN
-- Aggregate  (cost=369.21..369.22 rows=1 width=8) (actual time=5.705..5.705 rows=1 loops=1)
--   ->  Seq Scan on tickets  (cost=0.00..369.08 rows=54 width=0) (actual time=0.011..5.687 rows=51 loops=1)
--         Filter: (((buyed_at)::date <= CURRENT_DATE) AND ((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)))
--         Rows Removed by Filter: 9949
-- Planning Time: 0.145 ms
-- Execution Time: 5.745 ms

-- Добавляем индекс по дате продажи
CREATE INDEX idx_buyed_date ON tickets((buyed_at::date));

-- QUERY PLAN
-- Aggregate  (cost=76.61..76.62 rows=1 width=8) (actual time=0.235..0.236 rows=1 loops=1)
--   ->  Bitmap Heap Scan on tickets  (cost=4.81..76.49 rows=50 width=0) (actual time=0.123..0.228 rows=51 loops=1)
--         Recheck Cond: (((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((buyed_at)::date <= CURRENT_DATE))
--         Heap Blocks: exact=40
--         ->  Bitmap Index Scan on idx_buyed_date  (cost=0.00..4.79 rows=50 width=0) (actual time=0.104..0.104 rows=51 loops=1)
--               Index Cond: (((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((buyed_at)::date <= CURRENT_DATE))
-- Planning Time: 0.312 ms
-- Execution Time: 0.320 ms


-- Анализ этого запроса показал, что применение индекса
--  - улучшило стоимость получения первой строки и стоимость получения всех строк
--  - значительно снизилось время получения первой и всех строк
-- Вывод: применение индекса по дате покупке оправданно и полезно
