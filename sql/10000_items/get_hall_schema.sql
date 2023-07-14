explain analyse SELECT * FROM get_hall_schema(1);

-- Результат:
-- Function Scan on get_hall_schema  (cost=0.25..10.25 rows=1000 width=9) (actual time=162.426..163.218 rows=605 loops=1)
-- Planning Time: 0.057 ms
-- Execution Time: 164.031 ms

-- Индекс на столбец session_id таблицы session_place_price:
CREATE INDEX idx_session_id ON session_place_price (session_id);
-- Индекс на столбец place_id таблицы session_place_price:
CREATE INDEX idx_place_id ON session_place_price (place_id);
-- Индекс на столбец session_place_price_id таблицы tickets:
CREATE INDEX idx_session_place_price_id ON tickets (session_place_price_id);

explain analyse SELECT * FROM get_hall_schema(1);

-- Результат после приминения индексов:
-- Function Scan on get_hall_schema  (cost=0.25..10.25 rows=1000 width=9) (actual time=1.938..2.600 rows=605 loops=1)
-- Planning Time: 0.027 ms
-- Execution Time: 3.288 ms

-- Вывод: Индексы значительно повлияли на производительность запроса