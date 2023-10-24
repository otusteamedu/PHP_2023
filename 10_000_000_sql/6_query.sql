-- Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
-- Честно говоря я немного не правильно сделал архитектуру, когда уже дошел до этого запроса обнаружил, что сессия привязано 
-- к определенному price, не стал переделывать потомучто пришлось все запросы заново строить и производить проверки.
-- По хорошему тут многие ко многим, сессия может иметь много цен в зависимости от места и эти цены тоже могут иметь разные сессии

-- В данном случае нашел диапазон минимальной и максимальной цены за билет на конкретный фильм
explain analyse
select
    f.title as film_name,
    max(p.price) as max_price,
    min(p.price) as min_price
from
    sessions as s
    join films f on f.id = s.film_id
    join prices p on p.id = s.price_id
where f.id = 100
group by f.id;

-- QUERY PLAN
-- GroupAggregate  (cost=0.29..2011.52 rows=1 width=39) (actual time=12.838..12.838 rows=1 loops=1)
--   Group Key: f.id
--   ->  Nested Loop  (cost=0.29..2011.43 rows=10 width=35) (actual time=12.753..12.828 rows=5 loops=1)
--         Join Filter: (s.price_id = p.id)
--         Rows Removed by Join Filter: 495
--         ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.005..0.014 rows=100 loops=1)
--         ->  Materialize  (cost=0.29..1994.46 rows=10 width=35) (actual time=0.007..0.128 rows=5 loops=100)
--               ->  Nested Loop  (cost=0.29..1994.41 rows=10 width=35) (actual time=0.648..12.712 rows=5 loops=1)
--                     ->  Index Scan using films_pkey on films f  (cost=0.29..8.31 rows=1 width=31) (actual time=0.038..0.041 rows=1 loops=1)
--                           Index Cond: (id = 100)
--                     ->  Seq Scan on sessions s  (cost=0.00..1986.00 rows=10 width=8) (actual time=0.608..12.663 rows=5 loops=1)
--                           Filter: (film_id = 100)
--                           Rows Removed by Filter: 99995
-- Planning Time: 0.834 ms
-- Execution Time: 12.947 ms


-- Индекс по полю film_id
CREATE INDEX idx_film_id ON sessions(film_id);


-- QUERY PLAN
-- GroupAggregate  (cost=7.91..52.77 rows=1 width=39) (actual time=0.314..0.314 rows=1 loops=1)
--   Group Key: f.id
--   ->  Hash Join  (cost=7.91..52.68 rows=10 width=35) (actual time=0.279..0.306 rows=5 loops=1)
--         Hash Cond: (s.price_id = p.id)
--         ->  Nested Loop  (cost=4.66..49.41 rows=10 width=35) (actual time=0.071..0.096 rows=5 loops=1)
--               ->  Index Scan using films_pkey on films f  (cost=0.29..8.31 rows=1 width=31) (actual time=0.024..0.024 rows=1 loops=1)
--                     Index Cond: (id = 100)
--               ->  Bitmap Heap Scan on sessions s  (cost=4.37..41.00 rows=10 width=8) (actual time=0.044..0.066 rows=5 loops=1)
--                     Recheck Cond: (film_id = 100)
--                     Heap Blocks: exact=5
--                     ->  Bitmap Index Scan on idx_film_id  (cost=0.00..4.37 rows=10 width=0) (actual time=0.033..0.033 rows=5 loops=1)
--                           Index Cond: (film_id = 100)
--         ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.188..0.188 rows=100 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 12kB
--               ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.011..0.021 rows=100 loops=1)
-- Planning Time: 0.728 ms
-- Execution Time: 0.423 ms


-- Анализ этого запроса показал, что применение индекса
-- - улучшило стоимость получения первой строки и стоимость получения всех строк
-- - значительно снизилось время получения первой и всех строк
-- Вывод: применение индекса по дате покупке оправданно и полезно