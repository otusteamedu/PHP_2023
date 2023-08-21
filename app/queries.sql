--1. Выбор всех фильмов на сегодня
explain analyse select m.name
from movies m
         inner join sessions s on m.id = s.movie_id
where date(s.begin_at) = date(now());

drop index if exists session_begin_at_idx;
create index session_begin_at_idx on sessions (begin_at);
--------------------------------------------------------------
--10_000 без индексов

-- Hash Join  (cost=4.25..31.26 rows=5 width=51) (actual time=0.204..0.337 rows=4 loops=1)
--   Hash Cond: (s.movie_id = m.id)
--   ->  Seq Scan on sessions s  (cost=0.00..27.00 rows=5 width=4) (actual time=0.134..0.265 rows=4 loops=1)
--         Filter: (date(begin_at) = date(now()))
--         Rows Removed by Filter: 996
--   ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=0.051..0.052 rows=100 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 17kB
--         ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.004..0.017 rows=100 loops=1)
-- Planning Time: 0.567 ms
-- Execution Time: 0.394 ms
----------------------------------------------------------------
--10_000_000 без индексов

-- Gather  (cost=1004.25..16213.28 rows=5000 width=51) (actual time=0.640..63.803 rows=586 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Hash Join  (cost=4.25..14713.28 rows=2083 width=51) (actual time=0.681..57.239 rows=195 loops=3)
--         Hash Cond: (s.movie_id = m.id)
--         ->  Parallel Seq Scan on sessions s  (cost=0.00..14703.33 rows=2083 width=4) (actual time=0.258..56.670 rows=195 loops=3)
--               Filter: (date(begin_at) = date(now()))
--               Rows Removed by Filter: 333138
--         ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=0.052..0.052 rows=100 loops=3)
--               Buckets: 1024  Batches: 1  Memory Usage: 17kB
--               ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.012..0.023 rows=100 loops=3)
-- Planning Time: 0.323 ms
-- Execution Time: 63.903 ms
----------------------------------------------------------------
--10_000_000 c индексами

-- Gather  (cost=1004.25..16213.28 rows=5000 width=51) (actual time=0.518..68.145 rows=574 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Hash Join  (cost=4.25..14713.28 rows=2083 width=51) (actual time=0.661..63.005 rows=191 loops=3)
--         Hash Cond: (s.movie_id = m.id)
--         ->  Parallel Seq Scan on sessions s  (cost=0.00..14703.33 rows=2083 width=4) (actual time=0.318..62.472 rows=191 loops=3)
--               Filter: (date(begin_at) = date(now()))
--               Rows Removed by Filter: 333142
--         ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=0.050..0.051 rows=100 loops=3)
--               Buckets: 1024  Batches: 1  Memory Usage: 17kB
--               ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.012..0.023 rows=100 loops=3)
-- Planning Time: 0.238 ms
-- Execution Time: 68.255 ms
----------------------------------------------------------------

--2. Подсчёт проданных билетов за неделю
explain analyse select count(o.id)
from tickets o
         inner join sessions s on s.id = o.session_id
    and date(s.begin_at) between date(now() - interval '7 days') and date(now());

drop index if exists session_begin_at_idx;
create index session_begin_at_idx on sessions (begin_at);
--------------------------------------------------------------
--10_000 без индексов

-- Aggregate  (cost=230.05..230.06 rows=1 width=8) (actual time=1.045..1.047 rows=1 loops=1)
--   ->  Hash Join  (cost=39.56..229.92 rows=50 width=4) (actual time=0.164..1.033 rows=291 loops=1)
--         Hash Cond: (o.session_id = s.id)
--         ->  Seq Scan on tickets o  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.008..0.379 rows=10000 loops=1)
--         ->  Hash  (cost=39.50..39.50 rows=5 width=4) (actual time=0.148..0.148 rows=30 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 10kB
--               ->  Seq Scan on sessions s  (cost=0.00..39.50 rows=5 width=4) (actual time=0.005..0.138 rows=30 loops=1)
--                     Filter: ((date(begin_at) <= date(now())) AND (date(begin_at) >= date((now() - '7 days'::interval))))
--                     Rows Removed by Filter: 970
-- Planning Time: 0.328 ms
-- Execution Time: 1.088 ms
----------------------------------------------------------------
--10_000_000 без индексов

-- Finalize Aggregate  (cost=137288.53..137288.54 rows=1 width=8) (actual time=875.493..886.754 rows=1 loops=1)
--   ->  Gather  (cost=137288.32..137288.53 rows=2 width=8) (actual time=872.220..886.706 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=136288.32..136288.33 rows=1 width=8) (actual time=848.187..848.190 rows=1 loops=3)
--               ->  Parallel Hash Join  (cost=19937.70..136236.24 rows=20833 width=4) (actual time=98.883..846.380 rows=15309 loops=3)
--                     Hash Cond: (o.session_id = s.id)
--                     ->  Parallel Seq Scan on tickets o  (cost=0.00..105361.13 rows=4166613 width=8) (actual time=0.128..453.424 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=19911.67..19911.67 rows=2083 width=4) (actual time=98.042..98.043 rows=1535 loops=3)
--                           Buckets: 8192  Batches: 1  Memory Usage: 256kB
--                           ->  Parallel Seq Scan on sessions s  (cost=0.00..19911.67 rows=2083 width=4) (actual time=47.121..97.542 rows=1535 loops=3)
--                                 Filter: ((date(begin_at) <= date(now())) AND (date(begin_at) >= date((now() - '7 days'::interval))))
--                                 Rows Removed by Filter: 331798
-- Planning Time: 0.517 ms
-- JIT:
--   Functions: 44
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 8.985 ms, Inlining 0.000 ms, Optimization 10.560 ms, Emission 130.709 ms, Total 150.254 ms"
-- Execution Time: 1269.454 ms
----------------------------------------------------------------
--10_000_000 c индексами

-- Finalize Aggregate  (cost=137288.53..137288.54 rows=1 width=8) (actual time=832.718..836.100 rows=1 loops=1)
--   ->  Gather  (cost=137288.32..137288.53 rows=2 width=8) (actual time=832.401..836.079 rows=3 loops=1)
--         Workers Planned: 2
--         Workers Launched: 2
--         ->  Partial Aggregate  (cost=136288.32..136288.33 rows=1 width=8) (actual time=807.291..807.298 rows=1 loops=3)
--               ->  Parallel Hash Join  (cost=19937.70..136236.24 rows=20833 width=4) (actual time=74.411..805.433 rows=15266 loops=3)
--                     Hash Cond: (o.session_id = s.id)
--                     ->  Parallel Seq Scan on tickets o  (cost=0.00..105361.13 rows=4166613 width=8) (actual time=0.061..406.572 rows=3333333 loops=3)
--                     ->  Parallel Hash  (cost=19911.67..19911.67 rows=2083 width=4) (actual time=73.759..73.764 rows=1529 loops=3)
--                           Buckets: 8192  Batches: 1  Memory Usage: 288kB
--                           ->  Parallel Seq Scan on sessions s  (cost=0.00..19911.67 rows=2083 width=4) (actual time=15.203..73.026 rows=1529 loops=3)
--                                 Filter: ((date(begin_at) <= date(now())) AND (date(begin_at) >= date((now() - '7 days'::interval))))
--                                 Rows Removed by Filter: 331804
-- Planning Time: 0.640 ms
-- JIT:
--   Functions: 44
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 9.753 ms, Inlining 0.000 ms, Optimization 2.559 ms, Emission 42.939 ms, Total 55.251 ms"
-- Execution Time: 876.298 ms
----------------------------------------------------------------

--3. Формирование афиши (фильмы, которые показывают на этой неделе)
explain analyse select m.name
from movies m
         inner join sessions s on m.id = s.movie_id
where date(s.begin_at) between date(now()) and date(now() + interval '7 days');

drop index if exists session_begin_at_idx;
create index session_begin_at_idx on sessions (begin_at);
--------------------------------------------------------------
--10_000 без индексов

-- Hash Join  (cost=4.25..43.76 rows=5 width=51) (actual time=0.086..0.434 rows=31 loops=1)
--   Hash Cond: (s.movie_id = m.id)
--   ->  Seq Scan on sessions s  (cost=0.00..39.50 rows=5 width=4) (actual time=0.043..0.385 rows=31 loops=1)
--         Filter: ((date(begin_at) >= date(now())) AND (date(begin_at) <= date((now() + '7 days'::interval))))
--         Rows Removed by Filter: 969
--   ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=0.037..0.037 rows=100 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 17kB
--         ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.003..0.012 rows=100 loops=1)
-- Planning Time: 0.221 ms
-- Execution Time: 0.484 ms
----------------------------------------------------------------
--10_000_000 без индексов

-- Gather  (cost=1004.25..21421.62 rows=5000 width=51) (actual time=0.365..138.719 rows=4645 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Hash Join  (cost=4.25..19921.62 rows=2083 width=51) (actual time=0.343..116.719 rows=1548 loops=3)
--         Hash Cond: (s.movie_id = m.id)
--         ->  Parallel Seq Scan on sessions s  (cost=0.00..19911.67 rows=2083 width=4) (actual time=0.049..115.942 rows=1548 loops=3)
--               Filter: ((date(begin_at) >= date(now())) AND (date(begin_at) <= date((now() + '7 days'::interval))))
--               Rows Removed by Filter: 331785
--         ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=0.039..0.040 rows=100 loops=3)
--               Buckets: 1024  Batches: 1  Memory Usage: 17kB
--               ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.010..0.018 rows=100 loops=3)
-- Planning Time: 0.170 ms
-- Execution Time: 138.923 ms
----------------------------------------------------------------
--10_000_000 c индексами

-- Gather  (cost=1004.25..21421.62 rows=5000 width=51) (actual time=0.418..166.485 rows=4636 loops=1)
--   Workers Planned: 2
--   Workers Launched: 2
--   ->  Hash Join  (cost=4.25..19921.62 rows=2083 width=51) (actual time=0.424..137.596 rows=1545 loops=3)
--         Hash Cond: (s.movie_id = m.id)
--         ->  Parallel Seq Scan on sessions s  (cost=0.00..19911.67 rows=2083 width=4) (actual time=0.106..136.489 rows=1545 loops=3)
--               Filter: ((date(begin_at) >= date(now())) AND (date(begin_at) <= date((now() + '7 days'::interval))))
--               Rows Removed by Filter: 331788
--         ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=0.046..0.048 rows=100 loops=3)
--               Buckets: 1024  Batches: 1  Memory Usage: 17kB
--               ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.011..0.021 rows=100 loops=3)
-- Planning Time: 0.353 ms
-- Execution Time: 166.773 ms
----------------------------------------------------------------

--4. Поиск 3 самых прибыльных фильмов за неделю
explain analyse select sum(o.price), m.name
from tickets o
         inner join sessions s on s.id = o.session_id
    and date(s.begin_at) between date(now() - interval '7 days') and date(now())
         inner join movies m on m.id = s.movie_id
group by m.name
order by 1 desc
limit 3;

drop index if exists session_begin_at_idx;
create index session_begin_at_idx on sessions (begin_at);

--------------------------------------------------------------
--10_000 без индексов

-- Limit  (cost=237.24..237.24 rows=3 width=59) (actual time=1.367..1.369 rows=3 loops=1)
--   ->  Sort  (cost=237.24..237.36 rows=50 width=59) (actual time=1.366..1.368 rows=3 loops=1)
--         Sort Key: (sum(o.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  GroupAggregate  (cost=235.72..236.59 rows=50 width=59) (actual time=1.301..1.340 rows=26 loops=1)
--               Group Key: m.name
--               ->  Sort  (cost=235.72..235.84 rows=50 width=55) (actual time=1.294..1.303 rows=291 loops=1)
--                     Sort Key: m.name
--                     Sort Method: quicksort  Memory: 65kB
--                     ->  Hash Join  (cost=43.81..234.30 rows=50 width=55) (actual time=0.187..1.130 rows=291 loops=1)
--                           Hash Cond: (s.movie_id = m.id)
--                           ->  Hash Join  (cost=39.56..229.92 rows=50 width=8) (actual time=0.152..1.060 rows=291 loops=1)
--                                 Hash Cond: (o.session_id = s.id)
--                                 ->  Seq Scan on tickets o  (cost=0.00..164.00 rows=10000 width=8) (actual time=0.002..0.393 rows=10000 loops=1)
--                                 ->  Hash  (cost=39.50..39.50 rows=5 width=8) (actual time=0.143..0.143 rows=30 loops=1)
--                                       Buckets: 1024  Batches: 1  Memory Usage: 10kB
--                                       ->  Seq Scan on sessions s  (cost=0.00..39.50 rows=5 width=8) (actual time=0.004..0.135 rows=30 loops=1)
--                                             Filter: ((date(begin_at) <= date(now())) AND (date(begin_at) >= date((now() - '7 days'::interval))))
--                                             Rows Removed by Filter: 970
--                           ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=0.031..0.031 rows=100 loops=1)
--                                 Buckets: 1024  Batches: 1  Memory Usage: 17kB
--                                 ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.005..0.012 rows=100 loops=1)
-- Planning Time: 0.443 ms
-- Execution Time: 1.467 ms
----------------------------------------------------------------
--10_000_000 без индексов

-- Limit  (cost=137432.63..137432.63 rows=3 width=59) (actual time=569.506..572.259 rows=3 loops=1)
--   ->  Sort  (cost=137432.63..137432.88 rows=100 width=59) (actual time=551.754..554.506 rows=3 loops=1)
--         Sort Key: (sum(o.price)) DESC
--         Sort Method: top-N heapsort  Memory: 25kB
--         ->  Finalize GroupAggregate  (cost=137406.00..137431.33 rows=100 width=59) (actual time=551.524..554.414 rows=100 loops=1)
--               Group Key: m.name
--               ->  Gather Merge  (cost=137406.00..137429.33 rows=200 width=59) (actual time=551.496..554.335 rows=300 loops=1)
--                     Workers Planned: 2
--                     Workers Launched: 2
--                     ->  Sort  (cost=136405.97..136406.22 rows=100 width=59) (actual time=525.346..525.352 rows=100 loops=3)
--                           Sort Key: m.name
--                           Sort Method: quicksort  Memory: 39kB
--                           Worker 0:  Sort Method: quicksort  Memory: 39kB
--                           Worker 1:  Sort Method: quicksort  Memory: 39kB
--                           ->  Partial HashAggregate  (cost=136401.65..136402.65 rows=100 width=59) (actual time=525.068..525.082 rows=100 loops=3)
--                                 Group Key: m.name
--                                 Batches: 1  Memory Usage: 56kB
--                                 Worker 0:  Batches: 1  Memory Usage: 56kB
--                                 Worker 1:  Batches: 1  Memory Usage: 56kB
--                                 ->  Hash Join  (cost=19941.95..136297.49 rows=20833 width=55) (actual time=58.381..520.094 rows=15309 loops=3)
--                                       Hash Cond: (s.movie_id = m.id)
--                                       ->  Parallel Hash Join  (cost=19937.70..136236.24 rows=20833 width=8) (actual time=46.911..505.540 rows=15309 loops=3)
--                                             Hash Cond: (o.session_id = s.id)
--                                             ->  Parallel Seq Scan on tickets o  (cost=0.00..105361.13 rows=4166613 width=8) (actual time=0.052..195.559 rows=3333333 loops=3)
--                                             ->  Parallel Hash  (cost=19911.67..19911.67 rows=2083 width=8) (actual time=46.525..46.526 rows=1535 loops=3)
--                                                   Buckets: 8192  Batches: 1  Memory Usage: 320kB
--                                                   ->  Parallel Seq Scan on sessions s  (cost=0.00..19911.67 rows=2083 width=8) (actual time=0.051..45.947 rows=1535 loops=3)
--                                                         Filter: ((date(begin_at) <= date(now())) AND (date(begin_at) >= date((now() - '7 days'::interval))))
--                                                         Rows Removed by Filter: 331798
--                                       ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=11.419..11.420 rows=100 loops=3)
--                                             Buckets: 1024  Batches: 1  Memory Usage: 17kB
--                                             ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=11.380..11.391 rows=100 loops=3)
-- Planning Time: 0.604 ms
-- JIT:
--   Functions: 82
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 13.471 ms, Inlining 0.000 ms, Optimization 1.811 ms, Emission 50.276 ms, Total 65.558 ms"
-- Execution Time: 576.909 ms
----------------------------------------------------------------
--10_000_000 c индексами

----------------------------------------------------------------

--5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

explain analyse select hs.row,
       hs.seat,
       case
           when t.id is not null then 'занято'
           else 'свободно'
           end as busy
from hall_schema hs
         inner join sessions s on hs.hall_id = s.hall_id
         left join tickets t on hs.id = t.hall_schema_id and t.session_id = s.id
where s.id = 1
order by 1, 2;

--10_000 без индексов
--------------------------------------------------------------
-- Sort  (cost=246.83..247.62 rows=316 width=36) (actual time=1.180..1.202 rows=500 loops=1)
-- "  Sort Key: hs.""row"", hs.seat"
--   Sort Method: quicksort  Memory: 64kB
--   ->  Hash Right Join  (cost=44.63..233.71 rows=316 width=36) (actual time=0.290..0.969 rows=500 loops=1)
--         Hash Cond: ((t.session_id = s.id) AND (t.hall_schema_id = hs.id))
--         ->  Seq Scan on tickets t  (cost=0.00..189.00 rows=9 width=12) (actual time=0.045..0.647 rows=11 loops=1)
--               Filter: (session_id = 1)
--               Rows Removed by Filter: 9989
--         ->  Hash  (cost=39.89..39.89 rows=316 width=12) (actual time=0.213..0.216 rows=500 loops=1)
--               Buckets: 1024  Batches: 1  Memory Usage: 30kB
--               ->  Nested Loop  (cost=10.94..39.89 rows=316 width=12) (actual time=0.067..0.137 rows=500 loops=1)
--                     ->  Index Scan using sessions_pkey on sessions s  (cost=0.28..8.29 rows=1 width=8) (actual time=0.017..0.017 rows=1 loops=1)
--                           Index Cond: (id = 1)
--                     ->  Bitmap Heap Scan on hall_schema hs  (cost=10.67..28.52 rows=308 width=12) (actual time=0.046..0.073 rows=500 loops=1)
--                           Recheck Cond: (hall_id = s.hall_id)
--                           Heap Blocks: exact=3
--                           ->  Bitmap Index Scan on hall_schema_uniq_idx  (cost=0.00..10.59 rows=308 width=0) (actual time=0.035..0.035 rows=500 loops=1)
--                                 Index Cond: (hall_id = s.hall_id)
-- Planning Time: 0.617 ms
-- Execution Time: 1.317 ms
----------------------------------------------------------------
--10_000_000 без индексов

-- Sort  (cost=116985.85..116986.62 rows=306 width=36) (actual time=0.839..0.841 rows=0 loops=1)
-- "  Sort Key: hs.""row"", hs.seat"
--   Sort Method: quicksort  Memory: 25kB
--   ->  Nested Loop Left Join  (cost=1000.71..116973.22 rows=306 width=36) (actual time=0.802..0.804 rows=0 loops=1)
--         Join Filter: ((t.session_id = s.id) AND (hs.id = t.hall_schema_id))
--         ->  Nested Loop  (cost=0.71..135.53 rows=306 width=12) (actual time=0.802..0.802 rows=0 loops=1)
--               Join Filter: (hs.hall_id = s.hall_id)
--               ->  Index Scan using hall_schema_pkey on hall_schema hs  (cost=0.28..90.18 rows=2460 width=12) (actual time=0.034..0.561 rows=2460 loops=1)
--               ->  Materialize  (cost=0.42..8.45 rows=1 width=8) (actual time=0.000..0.000 rows=0 loops=2460)
--                     ->  Index Scan using sessions_pkey on sessions s  (cost=0.42..8.44 rows=1 width=8) (actual time=0.020..0.020 rows=0 loops=1)
--                           Index Cond: (id = 1)
--         ->  Materialize  (cost=1000.00..116778.82 rows=11 width=12) (never executed)
--               ->  Gather  (cost=1000.00..116778.76 rows=11 width=12) (never executed)
--                     Workers Planned: 2
--                     Workers Launched: 0
--                     ->  Parallel Seq Scan on tickets t  (cost=0.00..115777.66 rows=5 width=12) (never executed)
--                           Filter: (session_id = 1)
-- Planning Time: 1.136 ms
-- JIT:
--   Functions: 18
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 2.385 ms, Inlining 0.000 ms, Optimization 0.000 ms, Emission 0.000 ms, Total 2.385 ms"
-- Execution Time: 3.608 ms
--------------------------------------------------------------
--10_000_000 c индексами

----------------------------------------------------------------

--6. Вывести диапазон минимальной и максимальной цены за билет на конкретный сеанс
explain analyse select m.name, min(t.price), max(t.price)
from tickets t
         inner join sessions s on s.id = t.session_id
         inner join movies m on m.id = s.movie_id
where s.id = 1
group by m.name;

--------------------------------------------------------------
--10_000 без индексов

-- GroupAggregate  (cost=201.80..201.98 rows=9 width=59) (actual time=0.984..0.987 rows=1 loops=1)
--   Group Key: m.name
--   ->  Sort  (cost=201.80..201.82 rows=9 width=55) (actual time=0.975..0.978 rows=11 loops=1)
--         Sort Key: m.name
--         Sort Method: quicksort  Memory: 26kB
--         ->  Hash Join  (cost=4.53..201.66 rows=9 width=55) (actual time=0.166..0.955 rows=11 loops=1)
--               Hash Cond: (s.movie_id = m.id)
--               ->  Nested Loop  (cost=0.28..197.38 rows=9 width=8) (actual time=0.085..0.869 rows=11 loops=1)
--                     ->  Index Scan using sessions_pkey on sessions s  (cost=0.28..8.29 rows=1 width=8) (actual time=0.017..0.020 rows=1 loops=1)
--                           Index Cond: (id = 1)
--                     ->  Seq Scan on tickets t  (cost=0.00..189.00 rows=9 width=8) (actual time=0.066..0.845 rows=11 loops=1)
--                           Filter: (session_id = 1)
--                           Rows Removed by Filter: 9989
--               ->  Hash  (cost=3.00..3.00 rows=100 width=55) (actual time=0.067..0.068 rows=100 loops=1)
--                     Buckets: 1024  Batches: 1  Memory Usage: 17kB
--                     ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.004..0.018 rows=100 loops=1)
-- Planning Time: 0.382 ms
-- Execution Time: 1.083 ms
--------------------------------------------------------------
--10_000_000 без индексов

-- GroupAggregate  (cost=116790.79..116791.01 rows=11 width=59) (actual time=0.073..0.091 rows=0 loops=1)
--   Group Key: m.name
--   ->  Sort  (cost=116790.79..116790.82 rows=11 width=55) (actual time=0.072..0.089 rows=0 loops=1)
--         Sort Key: m.name
--         Sort Method: quicksort  Memory: 25kB
--         ->  Nested Loop  (cost=1008.46..116790.60 rows=11 width=55) (actual time=0.049..0.066 rows=0 loops=1)
--               ->  Hash Join  (cost=8.46..11.73 rows=1 width=55) (actual time=0.049..0.065 rows=0 loops=1)
--                     Hash Cond: (m.id = s.movie_id)
--                     ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=55) (actual time=0.008..0.009 rows=1 loops=1)
--                     ->  Hash  (cost=8.44..8.44 rows=1 width=8) (actual time=0.017..0.033 rows=0 loops=1)
--                           Buckets: 1024  Batches: 1  Memory Usage: 8kB
--                           ->  Index Scan using sessions_pkey on sessions s  (cost=0.42..8.44 rows=1 width=8) (actual time=0.017..0.017 rows=0 loops=1)
--                                 Index Cond: (id = 1)
--               ->  Gather  (cost=1000.00..116778.76 rows=11 width=8) (never executed)
--                     Workers Planned: 2
--                     Workers Launched: 0
--                     ->  Parallel Seq Scan on tickets t  (cost=0.00..115777.66 rows=5 width=8) (never executed)
--                           Filter: (session_id = 1)
-- Planning Time: 0.351 ms
-- JIT:
--   Functions: 23
-- "  Options: Inlining false, Optimization false, Expressions true, Deforming true"
-- "  Timing: Generation 3.074 ms, Inlining 0.000 ms, Optimization 0.000 ms, Emission 0.000 ms, Total 3.074 ms"
-- Execution Time: 3.667 ms
----------------------------------------------------------------
--10_000_000 c индексами

----------------------------------------------------------------

