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
-- GroupAggregate  (cost=209.31..219.89 rows=1 width=39) (actual time=0.920..0.920 rows=1 loops=1)
--   Group Key: f.id
--   ->  Nested Loop  (cost=209.31..219.87 rows=2 width=35) (actual time=0.905..0.913 rows=2 loops=1)
--         ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=31) (actual time=0.009..0.010 rows=1 loops=1)
--               Index Cond: (id = 100)
--         ->  Hash Join  (cost=209.03..211.55 rows=2 width=8) (actual time=0.893..0.900 rows=2 loops=1)
--               Hash Cond: (p.id = s.price_id)
--               ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.005..0.011 rows=100 loops=1)
--               ->  Hash  (cost=209.00..209.00 rows=2 width=8) (actual time=0.858..0.858 rows=2 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Seq Scan on sessions s  (cost=0.00..209.00 rows=2 width=8) (actual time=0.424..0.845 rows=2 loops=1)
--                           Filter: (film_id = 100)
--                           Rows Removed by Filter: 9998
-- Planning Time: 0.895 ms
-- Execution Time: 1.015 ms


-- Индекс по полю film_id
CREATE INDEX idx_film_id ON sessions(film_id);


-- QUERY PLAN
-- GroupAggregate  (cost=11.71..22.29 rows=1 width=39) (actual time=0.099..0.099 rows=1 loops=1)
--   Group Key: f.id
--   ->  Nested Loop  (cost=11.71..22.27 rows=2 width=35) (actual time=0.085..0.093 rows=2 loops=1)
--         ->  Index Scan using films_pkey on films f  (cost=0.29..8.30 rows=1 width=31) (actual time=0.007..0.008 rows=1 loops=1)
--               Index Cond: (id = 100)
--         ->  Hash Join  (cost=11.42..13.94 rows=2 width=8) (actual time=0.076..0.083 rows=2 loops=1)
--               Hash Cond: (p.id = s.price_id)
--               ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.004..0.010 rows=100 loops=1)
--               ->  Hash  (cost=11.40..11.40 rows=2 width=8) (actual time=0.040..0.040 rows=2 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 9kB
--                     ->  Bitmap Heap Scan on sessions s  (cost=4.30..11.40 rows=2 width=8) (actual time=0.022..0.033 rows=2 loops=1)
--                           Recheck Cond: (film_id = 100)
--                           Heap Blocks: exact=2
--                           ->  Bitmap Index Scan on idx_film_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.009..0.009 rows=2 loops=1)
--                                 Index Cond: (film_id = 100)
-- Planning Time: 0.583 ms
-- Execution Time: 0.208 ms


-- Анализ этого запроса показал, что применение индекса
-- - улучшило стоимость получения первой строки и стоимость получения всех строк
-- - значительно снизилось время получения первой и всех строк
-- Вывод: применение индекса по дате покупке оправданно и полезно