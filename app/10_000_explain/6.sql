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
-- GroupAggregate  (cost=196.64..196.68 rows=2 width=51) (actual time=0.621..0.622 rows=1 loops=1)
--   Group Key: m.id
--   ->  Sort  (cost=196.64..196.64 rows=2 width=47) (actual time=0.615..0.616 rows=2 loops=1)
--         Sort Key: m.id
--         Sort Method: quicksort  Memory: 25kB
--         ->  Nested Loop  (cost=0.57..196.63 rows=2 width=47) (actual time=0.327..0.609 rows=2 loops=1)
--               ->  Nested Loop  (cost=0.57..16.61 rows=1 width=47) (actual time=0.013..0.016 rows=1 loops=1)
--                     ->  Index Scan using session_pkey on session s  (cost=0.29..8.30 rows=1 width=8) (actual time=0.007..0.009 rows=1 loops=1)
--                           Index Cond: (id = 303)
--                     ->  Index Scan using movie_pkey on movie m  (cost=0.29..8.30 rows=1 width=43) (actual time=0.004..0.004 rows=1 loops=1)
--                           Index Cond: (id = s.movie_id)
--               ->  Seq Scan on price p  (cost=0.00..180.00 rows=2 width=8) (actual time=0.313..0.592 rows=2 loops=1)
--                     Filter: (session_id = 303)
--                     Rows Removed by Filter: 9998
-- Planning Time: 0.159 ms
-- Execution Time: 0.652 ms



-- Индекс для таблиц session и price по полю film_id
CREATE INDEX idx_session_movie_id ON session(movie_id);
CREATE INDEX idx_price_session_id ON price(session_id);


-- QUERY PLAN
-- GroupAggregate  (cost=27.82..27.86 rows=2 width=51) (actual time=0.031..0.032 rows=1 loops=1)
--   Group Key: m.id
--   ->  Sort  (cost=27.82..27.82 rows=2 width=47) (actual time=0.027..0.028 rows=2 loops=1)
--         Sort Key: m.id
--         Sort Method: quicksort  Memory: 25kB
--         ->  Nested Loop  (cost=4.87..27.81 rows=2 width=47) (actual time=0.021..0.023 rows=2 loops=1)
--               ->  Nested Loop  (cost=0.57..16.61 rows=1 width=47) (actual time=0.009..0.010 rows=1 loops=1)
--                     ->  Index Scan using session_pkey on session s  (cost=0.29..8.30 rows=1 width=8) (actual time=0.005..0.005 rows=1 loops=1)
--                           Index Cond: (id = 303)
--                     ->  Index Scan using movie_pkey on movie m  (cost=0.29..8.30 rows=1 width=43) (actual time=0.003..0.003 rows=1 loops=1)
--                           Index Cond: (id = s.movie_id)
--               ->  Bitmap Heap Scan on price p  (cost=4.30..11.18 rows=2 width=8) (actual time=0.010..0.012 rows=2 loops=1)
--                     Recheck Cond: (session_id = 303)
--                     Heap Blocks: exact=2
--                     ->  Bitmap Index Scan on idx_price_session_id  (cost=0.00..4.30 rows=2 width=0) (actual time=0.007..0.007 rows=2 loops=1)
--                           Index Cond: (session_id = 303)
-- Planning Time: 0.320 ms
-- Execution Time: 0.059 ms


-- По результату анализа запроса можно сказать следующее:
-- при добавлении индексов, стоимость и время выполнения запроса значительно уменьшились

-- Вывод: применение индексов оправданно
