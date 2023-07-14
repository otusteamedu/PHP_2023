explain analyse SELECT * FROM get_hall_schema(1);

-- Результат:
-- Function Scan on get_hall_schema  (cost=0.25..10.25 rows=1000 width=9) (actual time=247.403..248.204 rows=602 loops=1)
-- Planning Time: 0.048 ms
-- Execution Time: 249.004 ms


-- Индекс на столбец session_id таблицы session_place_price:
CREATE INDEX idx_session_id ON session_place_price (session_id);
-- Индекс на столбец place_id таблицы session_place_price:
CREATE INDEX idx_place_id ON session_place_price (place_id);
-- Индекс на столбец session_place_price_id таблицы tickets:
CREATE INDEX idx_session_place_price_id ON tickets (session_place_price_id);

explain analyse SELECT * FROM get_hall_schema(1);

-- Результат после приминения индексов:
-- Function Scan on get_hall_schema  (cost=0.25..10.25 rows=1000 width=9) (actual time=5.603..6.719 rows=602 loops=1)
-- Planning Time: 0.054 ms
-- Execution Time: 7.838 ms


-- Вывод: Индексы значительно повлияли на производительность запроса