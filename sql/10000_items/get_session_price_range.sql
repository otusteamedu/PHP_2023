explain analyse SELECT get_session_price_range(1);

-- Результат:
-- ProjectSet  (cost=0.00..5.27 rows=1000 width=32) (actual time=258.722..258.733 rows=1 loops=1)
--   ->  Result  (cost=0.00..0.01 rows=1 width=0) (actual time=0.003..0.007 rows=1 loops=1)
-- Planning Time: 0.044 ms
-- Execution Time: 258.773 ms


-- Индекс на столбец session_id таблицы session_place_price:
CREATE INDEX idx_session_id ON session_place_price (session_id);

explain analyse SELECT get_session_price_range(1);

-- Результат после приминения индексов:
-- ProjectSet  (cost=0.00..5.27 rows=1000 width=32) (actual time=1.313..1.327 rows=1 loops=1)
--   ->  Result  (cost=0.00..0.01 rows=1 width=0) (actual time=0.003..0.007 rows=1 loops=1)
-- Planning Time: 0.032 ms
-- Execution Time: 1.367 ms

-- Вывод: Индексы значительно повлияли на производительность запроса


