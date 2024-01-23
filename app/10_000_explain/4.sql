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
-- Limit  (cost=708.12..708.13 rows=3 width=528) (actual time=1.180..1.183 rows=0 loops=1)
--   ->  Sort  (cost=708.12..708.16 rows=15 width=528) (actual time=1.179..1.182 rows=0 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: quicksort  Memory: 25kB
--         ->  GroupAggregate  (cost=707.66..707.93 rows=15 width=528) (actual time=1.177..1.179 rows=0 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=707.66..707.70 rows=15 width=524) (actual time=1.176..1.178 rows=0 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 25kB
--                     ->  Nested Loop  (cost=336.84..707.37 rows=15 width=524) (actual time=1.174..1.176 rows=0 loops=1)
--                           ->  Nested Loop  (cost=336.56..701.95 rows=15 width=8) (actual time=1.173..1.175 rows=0 loops=1)
--                                 Join Filter: (s.id = t.session_id)
--                                 ->  Hash Join  (cost=336.27..696.67 rows=15 width=12) (actual time=1.173..1.174 rows=0 loops=1)
--                                       Hash Cond: ((p.session_id = t.session_id) AND (p.place_id = t.place_id))
--                                       ->  Seq Scan on price p  (cost=0.00..156.75 rows=10175 width=12) (actual time=0.005..0.005 rows=1 loops=1)
--                                       ->  Hash  (cost=335.40..335.40 rows=58 width=8) (actual time=1.164..1.165 rows=0 loops=1)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 8kB
--                                             ->  Seq Scan on ticket t  (cost=0.00..335.40 rows=58 width=8) (actual time=1.164..1.164 rows=0 loops=1)
--                                                   Filter: ((created_at <= CURRENT_DATE) AND (created_at >= (CURRENT_DATE - '7 days'::interval)))
--                                                   Rows Removed by Filter: 10000
--                                 ->  Index Scan using session_pkey on session s  (cost=0.29..0.34 rows=1 width=8) (never executed)
--                                       Index Cond: (id = p.session_id)
--                           ->  Index Scan using movie_pkey on movie m  (cost=0.28..0.36 rows=1 width=520) (never executed)
--                                 Index Cond: (id = s.movie_id)
-- Planning Time: 0.213 ms
-- Execution Time: 1.211 ms



-- Добавляем индексы для таблицы ticket и price
CREATE INDEX idx_ticket_created_at ON ticket(created_at);
CREATE INDEX idx_ticket_place_id ON ticket(place_id);
CREATE INDEX idx_price_session_id ON price(session_id);
CREATE INDEX idx_price_place_id ON price(place_id);

-- QUERY PLAN
-- Limit  (cost=17.41..17.41 rows=1 width=51) (actual time=0.008..0.009 rows=0 loops=1)
--   ->  Sort  (cost=17.41..17.41 rows=1 width=51) (actual time=0.007..0.007 rows=0 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: quicksort  Memory: 25kB
--         ->  GroupAggregate  (cost=17.38..17.40 rows=1 width=51) (actual time=0.005..0.006 rows=0 loops=1)
--               Group Key: m.id
--               ->  Sort  (cost=17.38..17.38 rows=1 width=47) (actual time=0.005..0.005 rows=0 loops=1)
--                     Sort Key: m.id
--                     Sort Method: quicksort  Memory: 25kB
--                     ->  Nested Loop  (cost=1.15..17.37 rows=1 width=47) (actual time=0.003..0.004 rows=0 loops=1)
--                           Join Filter: ((p.session_id = t.session_id) AND (t.place_id = p.place_id))
--                           ->  Nested Loop  (cost=0.86..16.99 rows=1 width=55) (actual time=0.003..0.004 rows=0 loops=1)
--                                 ->  Nested Loop  (cost=0.58..16.62 rows=1 width=16) (actual time=0.003..0.004 rows=0 loops=1)
--                                       ->  Index Scan using idx_ticket_created_at on ticket t  (cost=0.29..8.31 rows=1 width=8) (actual time=0.003..0.003 rows=0 loops=1)
--                                             Index Cond: ((created_at >= (CURRENT_DATE - '7 days'::interval)) AND (created_at <= CURRENT_DATE))
--                                       ->  Index Scan using session_pkey on session s  (cost=0.29..8.30 rows=1 width=8) (never executed)
--                                             Index Cond: (id = t.session_id)
--                                 ->  Index Scan using movie_pkey on movie m  (cost=0.29..0.37 rows=1 width=43) (never executed)
--                                       Index Cond: (id = s.movie_id)
--                           ->  Index Scan using idx_price_session_id on price p  (cost=0.29..0.35 rows=2 width=12) (never executed)
--                                 Index Cond: (session_id = s.id)
-- Planning Time: 0.536 ms
-- Execution Time: 0.030 ms


-- По результату анализа запроса можно сказать следующее:
-- Хоть и плановое время в запросе с индексом возрасло, стоимость и реальное время выполнения снизились в десятки раз

-- Вывод: применение индексов оправданно
