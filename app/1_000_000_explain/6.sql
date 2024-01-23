-- Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
explain analyse
select
    m.title as movie_name,
    max(p.price) as max_price,
    min(p.price) as min_price
from
    session s
    join movie m on m.id = s.movie_id
    join price p on p.session_id = s.id
where s.id = 303
group by m.id;

-- QUERY PLAN
-- GroupAggregate  (cost=11645.72..11647.78 rows=103 width=51) (actual time=22.292..25.703 rows=1 loops=1)
--   Group Key: m.id
--   ->  Sort  (cost=11645.72..11645.98 rows=103 width=47) (actual time=22.276..25.689 rows=117 loops=1)
--         Sort Key: m.id
--         Sort Method: quicksort  Memory: 32kB
--         ->  Nested Loop  (cost=1000.58..11642.28 rows=103 width=47) (actual time=0.411..25.665 rows=117 loops=1)
--               ->  Nested Loop  (cost=0.58..16.61 rows=1 width=47) (actual time=0.040..0.044 rows=1 loops=1)
--                     ->  Index Scan using session_pkey on session s  (cost=0.29..8.31 rows=1 width=8) (actual time=0.007..0.010 rows=1 loops=1)
--                           Index Cond: (id = 303)
--                     ->  Index Scan using movie_pkey on movie m  (cost=0.29..8.30 rows=1 width=43) (actual time=0.029..0.030 rows=1 loops=1)
--                           Index Cond: (id = s.movie_id)
--               ->  Gather  (cost=1000.00..11624.63 rows=103 width=8) (actual time=0.370..25.609 rows=117 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Parallel Seq Scan on price p  (cost=0.00..10614.33 rows=43 width=8) (actual time=0.142..12.996 rows=39 loops=3)
--                           Filter: (session_id = 303)
--                           Rows Removed by Filter: 333294
-- Planning Time: 0.193 ms
-- Execution Time: 25.739 ms


-- Индекс для таблиц session и price по полю film_id
CREATE INDEX idx_session_movie_id ON session(movie_id);
CREATE INDEX idx_price_session_id ON price(session_id);


-- QUERY PLAN
-- GroupAggregate  (cost=396.95..399.01 rows=103 width=51) (actual time=0.255..0.256 rows=1 loops=1)
--   Group Key: m.id
--   ->  Sort  (cost=396.95..397.20 rows=103 width=47) (actual time=0.241..0.245 rows=117 loops=1)
--         Sort Key: m.id
--         Sort Method: quicksort  Memory: 32kB
--         ->  Nested Loop  (cost=5.80..393.50 rows=103 width=47) (actual time=0.035..0.228 rows=117 loops=1)
--               ->  Nested Loop  (cost=0.58..16.61 rows=1 width=47) (actual time=0.010..0.011 rows=1 loops=1)
--                     ->  Index Scan using session_pkey on session s  (cost=0.29..8.31 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)
--                           Index Cond: (id = 303)
--                     ->  Index Scan using movie_pkey on movie m  (cost=0.29..8.30 rows=1 width=43) (actual time=0.003..0.003 rows=1 loops=1)
--                           Index Cond: (id = s.movie_id)
--               ->  Bitmap Heap Scan on price p  (cost=5.22..375.86 rows=103 width=8) (actual time=0.024..0.208 rows=117 loops=1)
--                     Recheck Cond: (session_id = 303)
--                     Heap Blocks: exact=116
--                     ->  Bitmap Index Scan on idx_price_session_id  (cost=0.00..5.20 rows=103 width=0) (actual time=0.011..0.011 rows=117 loops=1)
--                           Index Cond: (session_id = 303)
-- Planning Time: 0.254 ms
-- Execution Time: 0.279 ms

-- По результату анализа запроса можно сказать следующее:
-- при добавлении индексов, стоимость и время выполнения запроса значительно уменьшились

-- Вывод: применение индексов оправданно
