-- Подсчёт проданных билетов за неделю
explain analyse
    select
        count(*)
    from
        tickets
    where
        buyed_at::date between (current_date - INTERVAL '7 day') and current_date;

-- QUERY PLAN
-- Finalize Aggregate  (cost=189166.55..189166.56 rows=1 width=8) (actual time=1606.643..1606.643 rows=1 loops=1)
--   ->  Gather  (cost=189166.33..189166.54 rows=2 width=8) (actual time=1606.446..1610.980 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=188166.33..188166.34 rows=1 width=8) (actual time=1596.007..1596.007 rows=1 loops=3)
--               ->  Parallel Seq Scan on tickets  (cost=0.00..188114.25 rows=20833 width=0) (actual time=0.182..1593.373 rows=14755 loops=3)
--                     Filter: (((buyed_at)::date <= CURRENT_DATE) AND ((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)))
--                     Rows Removed by Filter: 3318578
-- Planning Time: 0.133 ms
-- Execution Time: 1611.052 ms

-- Добавляем индекс по дате продажи
CREATE INDEX idx_buyed_date ON tickets((buyed_at::date));

-- QUERY PLAN
-- Aggregate  (cost=72077.19..72077.20 rows=1 width=8) (actual time=237.932..237.933 rows=1 loops=1)
--   ->  Bitmap Heap Scan on tickets  (cost=1064.94..71952.19 rows=50000 width=0) (actual time=20.405..233.558 rows=44265 loops=1)
--         Recheck Cond: (((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((buyed_at)::date <= CURRENT_DATE))
--         Heap Blocks: exact=33218
--         ->  Bitmap Index Scan on idx_buyed_date  (cost=0.00..1052.44 rows=50000 width=0) (actual time=13.120..13.120 rows=44265 loops=1)
--               Index Cond: (((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((buyed_at)::date <= CURRENT_DATE))
-- Planning Time: 0.727 ms
-- Execution Time: 238.586 ms


-- Анализ этого запроса показал, что применение индекса
--  - улучшило стоимость получения первой строки и стоимость получения всех строк
--  - значительно снизилось время получения первой и всех строк
-- Вывод: применение индекса по дате покупке оправданно и полезно
