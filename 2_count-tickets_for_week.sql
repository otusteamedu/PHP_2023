select f.title, count(t.id), sum(t.price) from seances s
join tickets t on t.seance_id = s.id
join films f on f.id = s.film_id 
where s.start_at::date > current_date - interval '1 week'
and t.status = 'paid'
group by f.title 

/**
title                   |count|sum       |
------------------------+-----+----------+
Бременские музыканты    | 6856|1714000.00|
Три богатыря и Пуп Земли| 4877|1219250.00|
Феррари                 | 1500| 375000.00|
Фильм 1                 | 4733|1183250.00|
Последний наемник       |  255|  63750.00|
Холоп 2                 |10922|2730500.00|
*/


QUERY PLAN                                                                                                                                                 |
-----------------------------------------------------------------------------------------------------------------------------------------------------------+
Finalize GroupAggregate  (cost=4692.44..4696.57 rows=30 width=556) (actual time=39.985..42.459 rows=6 loops=1)                                             |
  Group Key: f.title                                                                                                                                       |
  ->  Gather Merge  (cost=4692.44..4695.89 rows=30 width=556) (actual time=39.973..42.439 rows=12 loops=1)                                                 |
        Workers Planned: 1                                                                                                                                 |
        Workers Launched: 1                                                                                                                                |
        ->  Sort  (cost=3692.43..3692.51 rows=30 width=556) (actual time=35.729..35.733 rows=6 loops=2)                                                    |
              Sort Key: f.title                                                                                                                            |
              Sort Method: quicksort  Memory: 25kB                                                                                                         |
              Worker 0:  Sort Method: quicksort  Memory: 25kB                                                                                              |
              ->  Partial HashAggregate  (cost=3691.32..3691.70 rows=30 width=556) (actual time=35.677..35.683 rows=6 loops=2)                             |
                    Group Key: f.title                                                                                                                     |
                    Batches: 1  Memory Usage: 24kB                                                                                                         |
                    Worker 0:  Batches: 1  Memory Usage: 24kB                                                                                              |
                    ->  Hash Join  (cost=55.39..3605.72 rows=11414 width=525) (actual time=1.931..30.340 rows=14572 loops=2)                               |
                          Hash Cond: (s.film_id = f.id)                                                                                                    |
                          ->  Hash Join  (cost=44.71..3560.85 rows=11414 width=13) (actual time=1.851..26.918 rows=14572 loops=2)                          |
                                Hash Cond: (t.seance_id = s.id)                                                                                            |
                                ->  Parallel Seq Scan on tickets t  (cost=0.00..3425.98 rows=34241 width=13) (actual time=0.013..19.603 rows=29192 loops=2)|
                                      Filter: ((status)::text = 'paid'::text)                                                                              |
                                      Rows Removed by Filter: 87291                                                                                        |
                                ->  Hash  (cost=38.90..38.90 rows=465 width=8) (actual time=1.006..1.007 rows=696 loops=2)                                 |
                                      Buckets: 1024  Batches: 1  Memory Usage: 36kB                                                                        |
                                      ->  Seq Scan on seances s  (cost=0.00..38.90 rows=465 width=8) (actual time=0.036..0.779 rows=696 loops=2)           |
                                            Filter: ((start_at)::date > (CURRENT_DATE - '7 days'::interval))                                               |
                                            Rows Removed by Filter: 699                                                                                    |
                          ->  Hash  (cost=10.30..10.30 rows=30 width=520) (actual time=0.033..0.033 rows=9 loops=2)                                        |
                                Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                               |
                                ->  Seq Scan on films f  (cost=0.00..10.30 rows=30 width=520) (actual time=0.020..0.023 rows=9 loops=2)                    |
Planning Time: 0.420 ms                                                                                                                                    |
Execution Time: 42.541 ms                                                                                                                                  |


create index status_idx on tickets (status);
create index start_at_idx on seances (DATE(start_at));


QUERY PLAN                                                                                                                                      |
------------------------------------------------------------------------------------------------------------------------------------------------+
HashAggregate  (cost=3501.77..3502.14 rows=30 width=556) (actual time=29.799..29.804 rows=6 loops=1)                                            |
  Group Key: f.title                                                                                                                            |
  Batches: 1  Memory Usage: 24kB                                                                                                                |
  ->  Hash Join  (cost=704.22..3356.25 rows=19403 width=525) (actual time=3.278..23.325 rows=29143 loops=1)                                     |
        Hash Cond: (s.film_id = f.id)                                                                                                           |
        ->  Hash Join  (cost=693.55..3287.44 rows=19403 width=13) (actual time=3.261..19.287 rows=29143 loops=1)                                |
              Hash Cond: (t.seance_id = s.id)                                                                                                   |
              ->  Bitmap Heap Scan on tickets t  (cost=655.55..3096.17 rows=58210 width=13) (actual time=2.474..10.644 rows=58383 loops=1)      |
                    Recheck Cond: ((status)::text = 'paid'::text)                                                                               |
                    Heap Blocks: exact=1713                                                                                                     |
                    ->  Bitmap Index Scan on status_idx  (cost=0.00..641.00 rows=58210 width=0) (actual time=2.253..2.253 rows=58383 loops=1)   |
                          Index Cond: ((status)::text = 'paid'::text)                                                                           |
              ->  Hash  (cost=32.19..32.19 rows=465 width=8) (actual time=0.315..0.316 rows=696 loops=1)                                        |
                    Buckets: 1024  Batches: 1  Memory Usage: 36kB                                                                               |
                    ->  Bitmap Heap Scan on seances s  (cost=11.89..32.19 rows=465 width=8) (actual time=0.036..0.173 rows=696 loops=1)         |
                          Recheck Cond: ((start_at)::date > (CURRENT_DATE - '7 days'::interval))                                                |
                          Heap Blocks: exact=11                                                                                                 |
                          ->  Bitmap Index Scan on start_at_idx  (cost=0.00..11.77 rows=465 width=0) (actual time=0.027..0.027 rows=696 loops=1)|
                                Index Cond: ((start_at)::date > (CURRENT_DATE - '7 days'::interval))                                            |
        ->  Hash  (cost=10.30..10.30 rows=30 width=520) (actual time=0.012..0.013 rows=9 loops=1)                                               |
              Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                      |
              ->  Seq Scan on films f  (cost=0.00..10.30 rows=30 width=520) (actual time=0.006..0.008 rows=9 loops=1)                           |
Planning Time: 0.409 ms                                                                                                                         |
Execution Time: 29.856 ms                                                                                                                       |