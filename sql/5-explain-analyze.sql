
-- 1
/*
|QUERY PLAN                                                                                                                                                                                   |
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Nested Loop Left Join  (cost=202548.50..203700.69 rows=13618 width=94) (actual time=380.111..382.199 rows=1068 loops=1)                                                                      |
|  ->  Hash Left Join  (cost=202548.50..202947.47 rows=1238 width=172) (actual time=380.097..381.745 rows=1068 loops=1)                                                                       |
|        Hash Cond: (tck.position_id = sp.id)                                                                                                                                                 |
|        ->  Hash Left Join  (cost=202536.99..202918.93 rows=1238 width=138) (actual time=380.016..381.516 rows=1068 loops=1)                                                                 |
|              Hash Cond: (d.session_id = sess.id)                                                                                                                                            |
|              ->  Hash Left Join  (cost=202535.90..202900.82 rows=1238 width=110) (actual time=379.995..381.364 rows=1068 loops=1)                                                           |
|                    Hash Cond: (d.hall_id = h.id)                                                                                                                                            |
|                    ->  Hash Right Join  (cost=202534.83..202882.73 rows=1238 width=82) (actual time=379.976..381.216 rows=1068 loops=1)                                                     |
|                          Hash Cond: (f.id = d.film_id)                                                                                                                                      |
|                          ->  Seq Scan on film f  (cost=0.00..248.01 rows=10001 width=26) (actual time=0.006..0.404 rows=10001 loops=1)                                                      |
|                          ->  Hash  (cost=202519.36..202519.36 rows=1238 width=64) (actual time=379.936..379.979 rows=1068 loops=1)                                                          |
|                                Buckets: 2048  Batches: 1  Memory Usage: 98kB                                                                                                                |
|                                ->  Merge Right Join  (cost=202160.62..202519.36 rows=1238 width=64) (actual time=378.035..379.783 rows=1068 loops=1)                                        |
|                                      Merge Cond: (d.id = tck.demonstration_id)                                                                                                              |
|                                      ->  Index Scan using demonstration_id_idx on demonstration d  (cost=0.43..323386.39 rows=9999997 width=20) (actual time=0.008..0.996 rows=9981 loops=1)|
|                                      ->  Sort  (cost=202160.19..202163.28 rows=1238 width=52) (actual time=358.495..358.588 rows=1068 loops=1)                                              |
|                                            Sort Key: tck.demonstration_id                                                                                                                   |
|                                            Sort Method: quicksort  Memory: 129kB                                                                                                            |
|                                            ->  Gather  (cost=1001.07..202096.59 rows=1238 width=52) (actual time=0.182..358.381 rows=1068 loops=1)                                          |
|                                                  Workers Planned: 2                                                                                                                         |
|                                                  Workers Launched: 2                                                                                                                        |
|                                                  ->  Hash Left Join  (cost=1.07..200972.79 rows=516 width=52) (actual time=77.329..349.265 rows=356 loops=3)                                |
|                                                        Hash Cond: (tck.status_id = s.id)                                                                                                    |
|                                                        ->  Parallel Seq Scan on ticket tck  (cost=0.00..200964.63 rows=516 width=24) (actual time=77.239..349.123 rows=356 loops=3)         |
|                                                              Filter: (showen_date = (now())::date)                                                                                          |
|                                                              Rows Removed by Filter: 3332976                                                                                                |
|                                                        ->  Hash  (cost=1.03..1.03 rows=3 width=36) (actual time=0.023..0.024 rows=3 loops=3)                                                |
|                                                              Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                   |
|                                                              ->  Seq Scan on dict_status s  (cost=0.00..1.03 rows=3 width=36) (actual time=0.019..0.020 rows=3 loops=3)                     |
|                    ->  Hash  (cost=1.03..1.03 rows=3 width=36) (actual time=0.008..0.009 rows=3 loops=1)                                                                                    |
|                          Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                                                       |
|                          ->  Seq Scan on dict_hall h  (cost=0.00..1.03 rows=3 width=36) (actual time=0.005..0.006 rows=3 loops=1)                                                           |
|              ->  Hash  (cost=1.04..1.04 rows=4 width=36) (actual time=0.008..0.009 rows=4 loops=1)                                                                                          |
|                    Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                                                             |
|                    ->  Seq Scan on dict_session sess  (cost=0.00..1.04 rows=4 width=36) (actual time=0.004..0.004 rows=4 loops=1)                                                           |
|        ->  Hash  (cost=7.34..7.34 rows=334 width=42) (actual time=0.075..0.076 rows=334 loops=1)                                                                                            |
|              Buckets: 1024  Batches: 1  Memory Usage: 33kB                                                                                                                                  |
|              ->  Seq Scan on seating_position sp  (cost=0.00..7.34 rows=334 width=42) (actual time=0.004..0.030 rows=334 loops=1)                                                           |
|  ->  Materialize  (cost=0.00..38.30 rows=11 width=4) (actual time=0.000..0.000 rows=1 loops=1068)                                                                                           |
|        ->  Seq Scan on _config cnf  (cost=0.00..38.25 rows=11 width=4) (actual time=0.006..0.006 rows=1 loops=1)                                                                            |
|              Filter: (id = 1)                                                                                                                                                               |
|Planning Time: 0.555 ms                                                                                                                                                                      |
|JIT:                                                                                                                                                                                         |
|  Functions: 85                                                                                                                                                                              |
|  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                              |
|  Timing: Generation 2.317 ms, Inlining 0.000 ms, Optimization 1.354 ms, Emission 29.172 ms, Total 32.842 ms                                                                                 |
|Execution Time: 383.712 ms                                                                                                                                                                   |
*/

-- 2
/*
|QUERY PLAN                                                                                                                                              |
|--------------------------------------------------------------------------------------------------------------------------------------------------------|
|Finalize Aggregate  (cost=265661.24..265661.25 rows=1 width=8) (actual time=506.652..509.415 rows=1 loops=1)                                            |
|  ->  Gather  (cost=265661.02..265661.23 rows=2 width=8) (actual time=506.543..509.403 rows=3 loops=1)                                                  |
|        Workers Planned: 2                                                                                                                              |
|        Workers Launched: 2                                                                                                                             |
|        ->  Partial Aggregate  (cost=264661.02..264661.03 rows=1 width=8) (actual time=497.433..497.434 rows=1 loops=3)                                 |
|              ->  Parallel Seq Scan on ticket tck  (cost=0.00..263464.60 rows=478570 width=4) (actual time=3.160..492.826 rows=121283 loops=3)          |
|                    Filter: ((status_id = 2) AND (purchasen_date <= (now())::date) AND ((((now())::date - '7 days'::interval))::date <= purchasen_date))|
|                    Rows Removed by Filter: 3212048                                                                                                     |
|Planning Time: 0.048 ms                                                                                                                                 |
|JIT:                                                                                                                                                    |
|  Functions: 17                                                                                                                                         |
|  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                         |
|  Timing: Generation 1.056 ms, Inlining 0.000 ms, Optimization 0.504 ms, Emission 8.887 ms, Total 10.447 ms                                             |
|Execution Time: 509.764 ms                                                                                                                              |
*/

-- 3
/*
|QUERY PLAN                                                                                                                                                                             |
|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Hash Left Join  (cost=202548.50..202966.04 rows=1238 width=62) (actual time=389.097..390.717 rows=1068 loops=1)                                                                        |
|  Hash Cond: (ticket.position_id = sp.id)                                                                                                                                              |
|  ->  Hash Left Join  (cost=202536.99..202918.93 rows=1238 width=98) (actual time=389.035..390.421 rows=1068 loops=1)                                                                  |
|        Hash Cond: (d.session_id = sess.id)                                                                                                                                            |
|        ->  Hash Left Join  (cost=202535.90..202900.82 rows=1238 width=70) (actual time=389.025..390.297 rows=1068 loops=1)                                                            |
|              Hash Cond: (d.hall_id = h.id)                                                                                                                                            |
|              ->  Hash Right Join  (cost=202534.83..202882.73 rows=1238 width=42) (actual time=389.009..390.164 rows=1068 loops=1)                                                     |
|                    Hash Cond: (f.id = d.film_id)                                                                                                                                      |
|                    ->  Seq Scan on film f  (cost=0.00..248.01 rows=10001 width=26) (actual time=0.006..0.401 rows=10001 loops=1)                                                      |
|                    ->  Hash  (cost=202519.36..202519.36 rows=1238 width=24) (actual time=388.968..389.016 rows=1068 loops=1)                                                          |
|                          Buckets: 2048  Batches: 1  Memory Usage: 75kB                                                                                                                |
|                          ->  Merge Right Join  (cost=202160.62..202519.36 rows=1238 width=24) (actual time=387.295..388.869 rows=1068 loops=1)                                        |
|                                Merge Cond: (d.id = ticket.demonstration_id)                                                                                                           |
|                                ->  Index Scan using demonstration_id_idx on demonstration d  (cost=0.43..323386.39 rows=9999997 width=16) (actual time=0.007..0.881 rows=9981 loops=1)|
|                                ->  Sort  (cost=202160.19..202163.28 rows=1238 width=16) (actual time=371.628..371.729 rows=1068 loops=1)                                              |
|                                      Sort Key: ticket.demonstration_id                                                                                                                |
|                                      Sort Method: quicksort  Memory: 107kB                                                                                                            |
|                                      ->  Gather  (cost=1001.07..202096.59 rows=1238 width=16) (actual time=0.187..371.449 rows=1068 loops=1)                                          |
|                                            Workers Planned: 2                                                                                                                         |
|                                            Workers Launched: 2                                                                                                                        |
|                                            ->  Hash Left Join  (cost=1.07..200972.79 rows=516 width=16) (actual time=89.819..362.552 rows=356 loops=3)                                |
|                                                  Hash Cond: (ticket.status_id = s.id)                                                                                                 |
|                                                  ->  Parallel Seq Scan on ticket  (cost=0.00..200964.63 rows=516 width=20) (actual time=89.723..362.411 rows=356 loops=3)             |
|                                                        Filter: (showen_date = (now())::date)                                                                                          |
|                                                        Rows Removed by Filter: 3332976                                                                                                |
|                                                  ->  Hash  (cost=1.03..1.03 rows=3 width=4) (actual time=0.027..0.027 rows=3 loops=3)                                                 |
|                                                        Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                   |
|                                                        ->  Seq Scan on dict_status s  (cost=0.00..1.03 rows=3 width=4) (actual time=0.023..0.024 rows=3 loops=3)                      |
|              ->  Hash  (cost=1.03..1.03 rows=3 width=36) (actual time=0.006..0.007 rows=3 loops=1)                                                                                    |
|                    Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                                                       |
|                    ->  Seq Scan on dict_hall h  (cost=0.00..1.03 rows=3 width=36) (actual time=0.003..0.004 rows=3 loops=1)                                                           |
|        ->  Hash  (cost=1.04..1.04 rows=4 width=36) (actual time=0.005..0.006 rows=4 loops=1)                                                                                          |
|              Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                                                             |
|              ->  Seq Scan on dict_session sess  (cost=0.00..1.04 rows=4 width=36) (actual time=0.003..0.003 rows=4 loops=1)                                                           |
|  ->  Hash  (cost=7.34..7.34 rows=334 width=8) (actual time=0.055..0.056 rows=334 loops=1)                                                                                             |
|        Buckets: 1024  Batches: 1  Memory Usage: 22kB                                                                                                                                  |
|        ->  Seq Scan on seating_position sp  (cost=0.00..7.34 rows=334 width=8) (actual time=0.004..0.026 rows=334 loops=1)                                                            |
|Planning Time: 0.534 ms                                                                                                                                                                |
|JIT:                                                                                                                                                                                   |
|  Functions: 76                                                                                                                                                                        |
|  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                        |
|  Timing: Generation 1.948 ms, Inlining 0.000 ms, Optimization 1.120 ms, Emission 25.130 ms, Total 28.198 ms                                                                           |
|Execution Time: 391.952 ms                                                                                                                                                             |
*/

-- 4
/*
|QUERY PLAN                                                                                                                                                                                    |
|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|Limit  (cost=296861.17..296861.18 rows=3 width=26) (actual time=652.464..654.688 rows=3 loops=1)                                                                                              |
|  ->  Sort  (cost=296861.17..296886.06 rows=9956 width=26) (actual time=643.634..645.857 rows=3 loops=1)                                                                                      |
|        Sort Key: (sum(t.price)) DESC                                                                                                                                                         |
|        Sort Method: top-N heapsort  Memory: 25kB                                                                                                                                             |
|        ->  Finalize GroupAggregate  (cost=294210.14..296732.49 rows=9956 width=26) (actual time=636.881..645.203 rows=6291 loops=1)                                                          |
|              Group Key: f.name                                                                                                                                                               |
|              ->  Gather Merge  (cost=294210.14..296533.37 rows=19912 width=26) (actual time=636.859..643.184 rows=18873 loops=1)                                                             |
|                    Workers Planned: 2                                                                                                                                                        |
|                    Workers Launched: 2                                                                                                                                                       |
|                    ->  Sort  (cost=293210.12..293235.01 rows=9956 width=26) (actual time=626.664..627.027 rows=6291 loops=3)                                                                 |
|                          Sort Key: f.name                                                                                                                                                    |
|                          Sort Method: quicksort  Memory: 635kB                                                                                                                               |
|                          Worker 0:  Sort Method: quicksort  Memory: 635kB                                                                                                                    |
|                          Worker 1:  Sort Method: quicksort  Memory: 635kB                                                                                                                    |
|                          ->  Partial HashAggregate  (cost=292449.41..292548.97 rows=9956 width=26) (actual time=611.581..612.190 rows=6291 loops=3)                                          |
|                                Group Key: f.name                                                                                                                                             |
|                                Batches: 1  Memory Usage: 1425kB                                                                                                                              |
|                                Worker 0:  Batches: 1  Memory Usage: 1425kB                                                                                                                   |
|                                Worker 1:  Batches: 1  Memory Usage: 1425kB                                                                                                                   |
|                                ->  Hash Left Join  (cost=373.47..290056.56 rows=478570 width=22) (actual time=7.829..586.619 rows=121283 loops=3)                                            |
|                                      Hash Cond: (d.film_id = f.id)                                                                                                                           |
|                                      ->  Nested Loop Left Join  (cost=0.45..283103.20 rows=478570 width=8) (actual time=5.695..561.464 rows=121283 loops=3)                                  |
|                                            ->  Parallel Seq Scan on ticket t  (cost=0.00..263464.60 rows=478570 width=8) (actual time=5.657..499.553 rows=121283 loops=3)                    |
|                                                  Filter: ((status_id = 2) AND (purchasen_date <= (now())::date) AND ((((now())::date - '7 days'::interval))::date <= purchasen_date))        |
|                                                  Rows Removed by Filter: 3212048                                                                                                             |
|                                            ->  Memoize  (cost=0.45..0.78 rows=1 width=8) (actual time=0.000..0.000 rows=1 loops=363850)                                                      |
|                                                  Cache Key: t.demonstration_id                                                                                                               |
|                                                  Cache Mode: logical                                                                                                                         |
|                                                  Hits: 111821  Misses: 10001  Evictions: 0  Overflows: 0  Memory Usage: 1055kB                                                               |
|                                                  Worker 0:  Hits: 112712  Misses: 10001  Evictions: 0  Overflows: 0  Memory Usage: 1055kB                                                    |
|                                                  Worker 1:  Hits: 109314  Misses: 10001  Evictions: 0  Overflows: 0  Memory Usage: 1055kB                                                    |
|                                                  ->  Index Scan using demonstration_id_idx on demonstration d  (cost=0.43..0.77 rows=1 width=8) (actual time=0.001..0.001 rows=1 loops=30003)|
|                                                        Index Cond: (id = t.demonstration_id)                                                                                                 |
|                                      ->  Hash  (cost=248.01..248.01 rows=10001 width=22) (actual time=2.087..2.087 rows=10001 loops=3)                                                       |
|                                            Buckets: 16384  Batches: 1  Memory Usage: 676kB                                                                                                   |
|                                            ->  Seq Scan on film f  (cost=0.00..248.01 rows=10001 width=22) (actual time=0.025..0.744 rows=10001 loops=3)                                     |
|Planning Time: 0.194 ms                                                                                                                                                                       |
|JIT:                                                                                                                                                                                          |
|  Functions: 82                                                                                                                                                                               |
|  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                                                               |
|  Timing: Generation 2.704 ms, Inlining 0.000 ms, Optimization 1.156 ms, Emission 24.598 ms, Total 28.457 ms                                                                                  |
|Execution Time: 656.236 ms                                                                                                                                                                    |
*/

-- 5
/*
|QUERY PLAN                                                                                                                                   |
|---------------------------------------------------------------------------------------------------------------------------------------------|
|GroupAggregate  (cost=17.40..18.40 rows=8 width=356) (actual time=0.219..0.344 rows=37 loops=1)                                              |
|  Group Key: l.number_in_row                                                                                                                 |
|  ->  Sort  (cost=17.40..17.42 rows=8 width=48) (actual time=0.210..0.220 rows=304 loops=1)                                                  |
|        Sort Key: l.number_in_row                                                                                                            |
|        Sort Method: quicksort  Memory: 44kB                                                                                                 |
|        ->  Hash Join  (cost=10.25..17.28 rows=8 width=48) (actual time=0.107..0.170 rows=304 loops=1)                                       |
|              Hash Cond: (l.id = sp.location_id)                                                                                             |
|              ->  Seq Scan on location l  (cost=0.00..5.81 rows=304 width=20) (actual time=0.007..0.027 rows=304 loops=1)                    |
|                    Filter: (floor = 1)                                                                                                      |
|                    Rows Removed by Filter: 1                                                                                                |
|              ->  Hash  (cost=10.15..10.15 rows=8 width=36) (actual time=0.098..0.098 rows=304 loops=1)                                      |
|                    Buckets: 1024  Batches: 1  Memory Usage: 21kB                                                                            |
|                    ->  Hash Join  (cost=1.11..10.15 rows=8 width=36) (actual time=0.010..0.075 rows=304 loops=1)                            |
|                          Hash Cond: ((sp.attendance_rate / 20) = uc.id)                                                                     |
|                          ->  Seq Scan on seating_position sp  (cost=0.00..8.18 rows=304 width=8) (actual time=0.003..0.025 rows=304 loops=1)|
|                                Filter: (hall_id = 3)                                                                                        |
|                                Rows Removed by Filter: 30                                                                                   |
|                          ->  Hash  (cost=1.05..1.05 rows=5 width=36) (actual time=0.004..0.005 rows=5 loops=1)                              |
|                                Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                 |
|                                ->  Seq Scan on dict_ui_color uc  (cost=0.00..1.05 rows=5 width=36) (actual time=0.002..0.002 rows=5 loops=1)|
|Planning Time: 0.130 ms                                                                                                                      |
|Execution Time: 0.374 ms                                                                                                                     |
*/

/*
|QUERY PLAN                                                                                                                                   |
|---------------------------------------------------------------------------------------------------------------------------------------------|
|GroupAggregate  (cost=17.40..20.48 rows=8 width=1188) (actual time=0.269..0.534 rows=11 loops=1)                                             |
|  Group Key: l."row"                                                                                                                         |
|  ->  Sort  (cost=17.40..17.42 rows=8 width=48) (actual time=0.242..0.253 rows=304 loops=1)                                                  |
|        Sort Key: l."row"                                                                                                                    |
|        Sort Method: quicksort  Memory: 44kB                                                                                                 |
|        ->  Hash Join  (cost=10.25..17.28 rows=8 width=48) (actual time=0.125..0.199 rows=304 loops=1)                                       |
|              Hash Cond: (l.id = sp.location_id)                                                                                             |
|              ->  Seq Scan on location l  (cost=0.00..5.81 rows=304 width=20) (actual time=0.007..0.031 rows=304 loops=1)                    |
|                    Filter: (floor = 1)                                                                                                      |
|                    Rows Removed by Filter: 1                                                                                                |
|              ->  Hash  (cost=10.15..10.15 rows=8 width=36) (actual time=0.114..0.115 rows=304 loops=1)                                      |
|                    Buckets: 1024  Batches: 1  Memory Usage: 21kB                                                                            |
|                    ->  Hash Join  (cost=1.11..10.15 rows=8 width=36) (actual time=0.011..0.087 rows=304 loops=1)                            |
|                          Hash Cond: ((sp.attendance_rate / 20) = uc.id)                                                                     |
|                          ->  Seq Scan on seating_position sp  (cost=0.00..8.18 rows=304 width=8) (actual time=0.004..0.030 rows=304 loops=1)|
|                                Filter: (hall_id = 3)                                                                                        |
|                                Rows Removed by Filter: 30                                                                                   |
|                          ->  Hash  (cost=1.05..1.05 rows=5 width=36) (actual time=0.004..0.005 rows=5 loops=1)                              |
|                                Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                 |
|                                ->  Seq Scan on dict_ui_color uc  (cost=0.00..1.05 rows=5 width=36) (actual time=0.002..0.002 rows=5 loops=1)|
|Planning Time: 0.220 ms                                                                                                                      |
|Execution Time: 0.584 ms                                                                                                                     |
*/

-- 6
/*
|QUERY PLAN                                                                                                                                              |
|--------------------------------------------------------------------------------------------------------------------------------------------------------|
|Sort  (cost=216430.13..216455.05 rows=9968 width=20) (actual time=739.562..741.495 rows=10001 loops=1)                                                  |
|  Sort Key: (count(demonstration_id)) DESC                                                                                                              |
|  Sort Method: quicksort  Memory: 1010kB                                                                                                                |
|  ->  Finalize GroupAggregate  (cost=213143.03..215768.10 rows=9968 width=20) (actual time=732.012..739.485 rows=10001 loops=1)                         |
|        Group Key: demonstration_id                                                                                                                     |
|        ->  Gather Merge  (cost=213143.03..215469.06 rows=19936 width=20) (actual time=731.997..736.488 rows=30003 loops=1)                             |
|              Workers Planned: 2                                                                                                                        |
|              Workers Launched: 2                                                                                                                       |
|              ->  Sort  (cost=212143.00..212167.92 rows=9968 width=20) (actual time=722.705..723.345 rows=10001 loops=3)                                |
|                    Sort Key: demonstration_id                                                                                                          |
|                    Sort Method: quicksort  Memory: 1010kB                                                                                              |
|                    Worker 0:  Sort Method: quicksort  Memory: 1010kB                                                                                   |
|                    Worker 1:  Sort Method: quicksort  Memory: 1010kB                                                                                   |
|                    ->  Partial HashAggregate  (cost=211381.30..211480.98 rows=9968 width=20) (actual time=719.990..720.944 rows=10001 loops=3)         |
|                          Group Key: demonstration_id                                                                                                   |
|                          Batches: 1  Memory Usage: 2449kB                                                                                              |
|                          Worker 0:  Batches: 1  Memory Usage: 2449kB                                                                                   |
|                          Worker 1:  Batches: 1  Memory Usage: 2449kB                                                                                   |
|                          ->  Parallel Seq Scan on ticket  (cost=0.00..169714.65 rows=4166665 width=8) (actual time=0.018..200.793 rows=3333332 loops=3)|
|Planning Time: 0.043 ms                                                                                                                                 |
|JIT:                                                                                                                                                    |
|  Functions: 24                                                                                                                                         |
|  Options: Inlining false, Optimization false, Expressions true, Deforming true                                                                         |
|  Timing: Generation 1.061 ms, Inlining 0.000 ms, Optimization 0.570 ms, Emission 12.687 ms, Total 14.318 ms                                            |
|Execution Time: 742.327 ms                                                                                                                              |
*/
