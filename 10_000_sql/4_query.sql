-- Поиск 3 самых прибыльных фильмов за неделю
explain analyse
select
    f.title,
    sum(p.price) as total_price
from
    tickets as t
    join sessions s on t.session_id = s.id
    join films f on s.film_id = f.id
    join prices p on p.id = s.price_id
where
    (t.buyed_at::date between (current_date - INTERVAL '7 day') and current_date)
group by
    f.id
order by
    total_price desc
limit 3;

-- QUERY PLAN
-- Limit  (cost=664.08..664.09 rows=3 width=39) (actual time=8.716..8.720 rows=3 loops=1)
--   ->  Sort  (cost=664.08..664.21 rows=50 width=39) (actual time=8.714..8.715 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=662.56..663.44 rows=50 width=39) (actual time=8.653..8.675 rows=51 loops=1)
--               Group Key: f.id
--               ->  Sort  (cost=662.56..662.69 rows=50 width=35) (actual time=8.644..8.648 rows=51 loops=1)
--                     Sort Key: f.id
--                     Sort Method: quicksort  Memory: 29kB
--                     ->  Nested Loop  (cost=350.05..661.15 rows=50 width=35) (actual time=5.831..8.576 rows=51 loops=1)
--                           ->  Nested Loop  (cost=349.91..653.09 rows=50 width=35) (actual time=5.812..8.491 rows=51 loops=1)
--                                 ->  Hash Join  (cost=349.63..634.12 rows=50 width=8) (actual time=5.767..8.226 rows=51 loops=1)
--                                       Hash Cond: (s.id = t.session_id)
--                                       ->  Seq Scan on sessions s  (cost=0.00..184.00 rows=10000 width=12) (actual time=0.006..1.594 rows=10000 loops=1)
--                                       ->  Hash  (cost=349.00..349.00 rows=50 width=4) (actual time=5.721..5.721 rows=51 loops=1)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 10kB
--                                             ->  Seq Scan on tickets t  (cost=0.00..349.00 rows=50 width=4) (actual time=0.010..5.679 rows=51 loops=1)
--                                                   Filter: (((buyed_at)::date <= CURRENT_DATE) AND ((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)))
--                                                   Rows Removed by Filter: 9949
--                                 ->  Index Scan using films_pkey on films f  (cost=0.29..0.38 rows=1 width=31) (actual time=0.005..0.005 rows=1 loops=51)
--                                       Index Cond: (id = s.film_id)
--                           ->  Index Scan using prices_pkey on prices p  (cost=0.14..0.16 rows=1 width=8) (actual time=0.001..0.001 rows=1 loops=51)
--                                 Index Cond: (id = s.price_id)
-- Planning Time: 0.877 ms
-- Execution Time: 8.841 ms


-- Добавляем индекс по дате продажи
CREATE INDEX idx_buyed_date ON tickets((buyed_at::date));


-- QUERY PLAN
-- Limit  (cost=386.89..386.90 rows=3 width=39) (actual time=3.150..3.154 rows=3 loops=1)
--   ->  Sort  (cost=386.89..387.02 rows=50 width=39) (actual time=3.149..3.149 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=385.37..386.24 rows=50 width=39) (actual time=3.082..3.105 rows=51 loops=1)
--               Group Key: f.id
--               ->  Sort  (cost=385.37..385.49 rows=50 width=35) (actual time=3.075..3.079 rows=51 loops=1)
--                     Sort Key: f.id
--                     Sort Method: quicksort  Memory: 29kB
--                     ->  Hash Join  (cost=80.65..383.96 rows=50 width=35) (actual time=0.278..3.036 rows=51 loops=1)
--                           Hash Cond: (s.price_id = p.id)
--                           ->  Nested Loop  (cost=77.40..380.58 rows=50 width=35) (actual time=0.224..2.962 rows=51 loops=1)
--                                 ->  Hash Join  (cost=77.11..361.61 rows=50 width=8) (actual time=0.201..2.710 rows=51 loops=1)
--                                       Hash Cond: (s.id = t.session_id)
--                                       ->  Seq Scan on sessions s  (cost=0.00..184.00 rows=10000 width=12) (actual time=0.005..1.649 rows=10000 loops=1)
--                                       ->  Hash  (cost=76.49..76.49 rows=50 width=4) (actual time=0.158..0.158 rows=51 loops=1)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 10kB
--                                             ->  Bitmap Heap Scan on tickets t  (cost=4.81..76.49 rows=50 width=4) (actual time=0.045..0.144 rows=51 loops=1)
--                                                   Recheck Cond: (((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((buyed_at)::date <= CURRENT_DATE))
--                                                   Heap Blocks: exact=40
--                                                   ->  Bitmap Index Scan on idx_buyed_date  (cost=0.00..4.79 rows=50 width=0) (actual time=0.035..0.035 rows=51 loops=1)
--                                                         Index Cond: (((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((buyed_at)::date <= CURRENT_DATE))
--                                 ->  Index Scan using films_pkey on films f  (cost=0.29..0.38 rows=1 width=31) (actual time=0.004..0.004 rows=1 loops=51)
--                                       Index Cond: (id = s.film_id)
--                           ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.037..0.037 rows=100 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 12kB
--                                 ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.006..0.016 rows=100 loops=1)
-- Planning Time: 1.103 ms
-- Execution Time: 3.315 ms


-- Анализ этого запроса показал, что применение индекса
-- - улучшило стоимость получения первой строки и стоимость получения всех строк
-- - значительно снизилось время получения первой и всех строк
-- Вывод: применение индекса по дате покупке оправданно и полезно