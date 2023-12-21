--Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
EXPLAIN
ANALYSE
SELECT min(t.price) as min_price,
       max(t.price) as max_price
FROM tickets as t
WHERE showtime_id = 1;
-- Aggregate  (cost=176.22..176.23 rows=1 width=64) (actual time=2.775..2.776 rows=1 loops=1)
-- Planning Time: 0.284 ms
-- Execution Time: 2.845 ms

create index idx_price ON tickets (price);
-- Result  (cost=23.57..23.58 rows=1 width=64) (actual time=0.408..0.409 rows=1 loops=1)
-- Planning Time: 1.345 ms
-- Execution Time: 0.454 ms

-- Запрос после создания индекса
EXPLAIN
ANALYSE
SELECT min(t.price) as min_price,
       max(t.price) as max_price
FROM tickets as t
WHERE showtime_id = 1;
-- Aggregate  (cost=176.22..176.23 rows=1 width=64) (actual time=1.845..1.863 rows=1 loops=1)
-- Planning Time: 0.094 ms
-- Execution Time: 0.795 ms

-- Вывод: Индексы значительно повлияли на производительность запроса