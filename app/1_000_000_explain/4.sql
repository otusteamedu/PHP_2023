-- Поиск 3 самых прибыльных фильмов за неделю
explain analyse
select
    m.title,
    sum(p.price) as total_price
from
    ticket t
    join session s on t.session_id = s.id
    join movie m on s.movie_id = m.id
    join price p on p.session_id = s.id and t.place_id = p.place_id
where
    t.created_at between (CURRENT_DATE - INTERVAL '7 day') and CURRENT_DATE
group by
    m.id
order by
    total_price desc
limit 3;

-- QUERY PLAN
-- Limit  (cost=30426.47..30426.47 rows=1 width=51) (actual time=42.248..46.523 rows=0 loops=1)
--   ->  Sort  (cost=30426.47..30426.47 rows=1 width=51) (actual time=42.247..46.522 rows=0 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: quicksort  Memory: 25kB
--         ->  GroupAggregate  (cost=30426.44..30426.46 rows=1 width=51) (actual time=42.244..46.519 rows=0 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=30426.44..30426.44 rows=1 width=47) (actual time=42.243..46.517 rows=0 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 25kB
--                     ->  Nested Loop  (cost=17728.59..30426.43 rows=1 width=47) (actual time=42.240..46.515 rows=0 loops=1)
--                           ->  Nested Loop  (cost=17728.31..30426.12 rows=1 width=8) (actual time=42.240..46.514 rows=0 loops=1)
--                                 Join Filter: (s.id = t.session_id)
--                                 ->  Gather  (cost=17728.01..30425.79 rows=1 width=12) (actual time=42.240..46.512 rows=0 loops=1)
--                                       Workers Planned: 2
--                                       Workers Launched: 2
--                                       ->  Parallel Hash Join  (cost=16728.01..29425.69 rows=1 width=12) (actual time=33.078..33.080 rows=0 loops=3)
--                                             Hash Cond: ((p.session_id = t.session_id) AND (p.place_id = t.place_id))
--                                             ->  Parallel Seq Scan on price p  (cost=0.00..9572.67 rows=416667 width=12) (never executed)
--                                             ->  Parallel Hash  (cost=16728.00..16728.00 rows=1 width=8) (actual time=32.929..32.930 rows=0 loops=3)
--                                                   Buckets: 1024  Batches: 1  Memory Usage: 0kB
--                                                   ->  Parallel Seq Scan on ticket t  (cost=0.00..16728.00 rows=1 width=8) (actual time=32.898..32.898 rows=0 loops=3)
--                                                         Filter: ((created_at <= CURRENT_DATE) AND (created_at >= (CURRENT_DATE - '7 days'::interval)))
--                                                         Rows Removed by Filter: 333333
--                                 ->  Index Scan using session_pkey on session s  (cost=0.29..0.31 rows=1 width=8) (never executed)
--                                       Index Cond: (id = p.session_id)
--                           ->  Index Scan using movie_pkey on movie m  (cost=0.29..0.31 rows=1 width=43) (never executed)
--                                 Index Cond: (id = s.movie_id)
-- Planning Time: 0.423 ms
-- Execution Time: 46.562 ms

-- Добавляем индексы для таблицы ticket и price
CREATE INDEX idx_ticket_created_at ON ticket(created_at);
CREATE INDEX idx_ticket_place_id ON ticket(place_id);
CREATE INDEX idx_price_session_id ON price(session_id);
CREATE INDEX idx_price_place_id ON price(place_id);

-- QUERY PLAN
-- Limit  (cost=21.14..21.14 rows=1 width=51) (actual time=0.009..0.010 rows=0 loops=1)
--   ->  Sort  (cost=21.14..21.14 rows=1 width=51) (actual time=0.009..0.009 rows=0 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: quicksort  Memory: 25kB
--         ->  GroupAggregate  (cost=21.11..21.13 rows=1 width=51) (actual time=0.007..0.007 rows=0 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=21.11..21.11 rows=1 width=47) (actual time=0.006..0.006 rows=0 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 25kB
--                     ->  Nested Loop  (cost=1.44..21.10 rows=1 width=47) (actual time=0.005..0.005 rows=0 loops=1)
--                           Join Filter: ((p.session_id = t.session_id) AND (t.place_id = p.place_id))
--                           ->  Nested Loop  (cost=1.01..17.07 rows=1 width=55) (actual time=0.004..0.005 rows=0 loops=1)
--                                 ->  Nested Loop  (cost=0.72..16.76 rows=1 width=16) (actual time=0.004..0.005 rows=0 loops=1)
--                                       ->  Index Scan using idx_ticket_created_at on ticket t  (cost=0.43..8.45 rows=1 width=8) (actual time=0.004..0.004 rows=0 loops=1)
--                                             Index Cond: ((created_at >= (CURRENT_DATE - '7 days'::interval)) AND (created_at <= CURRENT_DATE))
--                                       ->  Index Scan using session_pkey on session s  (cost=0.29..8.31 rows=1 width=8) (never executed)
--                                             Index Cond: (id = t.session_id)
--                                 ->  Index Scan using movie_pkey on movie m  (cost=0.29..0.31 rows=1 width=43) (never executed)
--                                       Index Cond: (id = s.movie_id)
--                           ->  Index Scan using idx_price_session_id on price p  (cost=0.42..2.48 rows=103 width=12) (never executed)
--                                 Index Cond: (session_id = s.id)
-- Planning Time: 0.672 ms
-- Execution Time: 0.034 ms

-- По результату анализа запроса можно сказать следующее:
-- Хоть и плановое время в запросе с индексом возрасло, стоимость и реальное время выполнения снизились в сотни раз

-- Вывод: применение индексов оправданно
