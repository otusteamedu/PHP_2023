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
-- Limit  (cost=204376.37..204376.37 rows=3 width=39) (actual time=1615.003..1618.970 rows=3 loops=1)
--   ->  Sort  (cost=204376.37..204501.37 rows=50000 width=39) (actual time=1615.002..1615.002 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=197847.93..203730.13 rows=50000 width=39) (actual time=1602.320..1614.140 rows=6253 loops=1)
--               Group Key: f.id
--               ->  Gather Merge  (cost=197847.93..203021.80 rows=41666 width=39) (actual time=1602.313..1614.496 rows=16037 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Partial GroupAggregate  (cost=196847.90..197212.48 rows=20833 width=39) (actual time=1598.479..1603.075 rows=5346 loops=3)
--                           Group Key: f.id
--                           ->  Sort  (cost=196847.90..196899.99 rows=20833 width=35) (actual time=1598.471..1599.930 rows=14755 loops=3)
--                                 Sort Key: f.id
--                                 Sort Method: quicksort  Memory: 1623kB
--                                 Worker 0:  Sort Method: quicksort  Memory: 1601kB
--                                 Worker 1:  Sort Method: quicksort  Memory: 1608kB
--                                 ->  Hash Join  (cost=6420.79..195353.49 rows=20833 width=35) (actual time=70.288..1591.732 rows=14755 loops=3)
--                                       Hash Cond: (s.price_id = p.id)
--                                       ->  Parallel Hash Join  (cost=6417.54..195293.24 rows=20833 width=35) (actual time=70.205..1587.342 rows=14755 loops=3)
--                                             Hash Cond: (s.film_id = f.id)
--                                             ->  Hash Join  (cost=3475.00..192296.02 rows=20833 width=8) (actual time=41.298..1548.985 rows=14755 loops=3)
--                                                   Hash Cond: (t.session_id = s.id)
--                                                   ->  Parallel Seq Scan on tickets t  (cost=0.00..188113.33 rows=20833 width=4) (actual time=0.125..1487.944 rows=14755 loops=3)
--                                                         Filter: (((buyed_at)::date <= CURRENT_DATE) AND ((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)))
--                                                         Rows Removed by Filter: 3318578
--                                                   ->  Hash  (cost=1736.00..1736.00 rows=100000 width=12) (actual time=39.959..39.960 rows=100000 loops=3)
--                                                         Buckets: 131072  Batches: 2  Memory Usage: 3172kB
--                                                         ->  Seq Scan on sessions s  (cost=0.00..1736.00 rows=100000 width=12) (actual time=0.017..15.081 rows=100000 loops=3)
--                                             ->  Parallel Hash  (cost=2207.24..2207.24 rows=58824 width=31) (actual time=28.131..28.132 rows=33333 loops=3)
--                                                   Buckets: 131072  Batches: 1  Memory Usage: 7648kB
--                                                   ->  Parallel Seq Scan on films f  (cost=0.00..2207.24 rows=58824 width=31) (actual time=0.009..12.052 rows=33333 loops=3)
--                                       ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.055..0.055 rows=100 loops=3)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 12kB
--                                             ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.021..0.032 rows=100 loops=3)
-- Planning Time: 0.876 ms
-- Execution Time: 1620.019 ms


-- Добавляем индекс по дате продажи
CREATE INDEX idx_buyed_date ON tickets((buyed_at::date));


-- QUERY PLAN
-- Limit  (cost=83076.06..83076.07 rows=3 width=39) (actual time=437.576..437.580 rows=3 loops=1)
--   ->  Sort  (cost=83076.06..83201.06 rows=50000 width=39) (actual time=437.574..437.575 rows=3 loops=1)
--         Sort Key: (sum(p.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=80482.23..82429.82 rows=50000 width=39) (actual time=410.654..436.508 rows=6253 loops=1)
--               Group Key: f.id
--               ->  Merge Join  (cost=80482.23..81679.82 rows=50000 width=35) (actual time=410.637..429.733 rows=44265 loops=1)
--                     Merge Cond: (f.id = s.film_id)
--                     ->  Index Scan using films_pkey on films f  (cost=0.29..4228.68 rows=100000 width=31) (actual time=0.005..3.650 rows=10001 loops=1)
--                     ->  Sort  (cost=80481.91..80606.91 rows=50000 width=8) (actual time=410.627..415.670 rows=44265 loops=1)
--                           Sort Key: s.film_id
--                           Sort Method: quicksort  Memory: 3441kB
--                           ->  Hash Join  (cost=4543.19..76579.50 rows=50000 width=8) (actual time=62.970..396.170 rows=44265 loops=1)
--                                 Hash Cond: (s.price_id = p.id)
--                                 ->  Hash Join  (cost=4539.94..76439.44 rows=50000 width=8) (actual time=62.916..385.197 rows=44265 loops=1)
--                                       Hash Cond: (t.session_id = s.id)
--                                       ->  Bitmap Heap Scan on tickets t  (cost=1064.94..71952.19 rows=50000 width=4) (actual time=20.339..302.700 rows=44265 loops=1)
--                                             Recheck Cond: (((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((buyed_at)::date <= CURRENT_DATE))
--                                             Heap Blocks: exact=33218
--                                             ->  Bitmap Index Scan on idx_buyed_date  (cost=0.00..1052.44 rows=50000 width=0) (actual time=13.155..13.155 rows=44265 loops=1)
--                                                   Index Cond: (((buyed_at)::date >= (CURRENT_DATE - '7 days'::interval)) AND ((buyed_at)::date <= CURRENT_DATE))
--                                       ->  Hash  (cost=1736.00..1736.00 rows=100000 width=12) (actual time=41.705..41.705 rows=100000 loops=1)
--                                             Buckets: 131072  Batches: 2  Memory Usage: 3172kB
--                                             ->  Seq Scan on sessions s  (cost=0.00..1736.00 rows=100000 width=12) (actual time=0.014..16.311 rows=100000 loops=1)
--                                 ->  Hash  (cost=2.00..2.00 rows=100 width=8) (actual time=0.034..0.034 rows=100 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 12kB
--                                       ->  Seq Scan on prices p  (cost=0.00..2.00 rows=100 width=8) (actual time=0.006..0.016 rows=100 loops=1)
-- Planning Time: 1.680 ms
-- Execution Time: 439.169 ms


-- Анализ этого запроса показал, что применение индекса
-- - улучшило стоимость получения первой строки и стоимость получения всех строк, более 3х раз
-- - значительно снизилось время получения первой и всех строк
-- Вывод: применение индекса по дате покупке оправданно и полезно