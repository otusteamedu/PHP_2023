select f.title, sum(t.price) from tickets t
join seances s on t.seance_id = s.id
join films f on f.id = s.film_id 
where status = 'paid'
and s.start_at::date > current_date - interval '1 week'
group by f.title 
order by sum desc
limit 3

/**
title                   |sum       |
------------------------+----------+
Холоп 2                 |2730500.00|
Бременские музыканты    |1714000.00|
Три богатыря и Пуп Земли|1219250.00|
*/

QUERY PLAN                                                                                                                                                  |
------------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=3454.02..3454.03 rows=3 width=548) (actual time=40.687..40.692 rows=3 loops=1)                                                                 |
  ->  Sort  (cost=3454.02..3454.10 rows=30 width=548) (actual time=40.685..40.690 rows=3 loops=1)                                                           |
        Sort Key: (sum(t.price)) DESC                                                                                                                       |
        Sort Method: quicksort  Memory: 25kB                                                                                                                |
        ->  HashAggregate  (cost=3453.26..3453.64 rows=30 width=548) (actual time=40.673..40.680 rows=6 loops=1)                                            |
              Group Key: f.title                                                                                                                            |
              Batches: 1  Memory Usage: 24kB                                                                                                                |
              ->  Hash Join  (cost=704.22..3356.25 rows=19403 width=521) (actual time=2.963..31.343 rows=29143 loops=1)                                     |
                    Hash Cond: (s.film_id = f.id)                                                                                                           |
                    ->  Hash Join  (cost=693.55..3287.44 rows=19403 width=9) (actual time=2.945..25.253 rows=29143 loops=1)                                 |
                          Hash Cond: (t.seance_id = s.id)                                                                                                   |
                          ->  Bitmap Heap Scan on tickets t  (cost=655.55..3096.17 rows=58210 width=9) (actual time=2.274..13.274 rows=58383 loops=1)       |
                                Recheck Cond: ((status)::text = 'paid'::text)                                                                               |
                                Heap Blocks: exact=1713                                                                                                     |
                                ->  Bitmap Index Scan on status_idx  (cost=0.00..641.00 rows=58210 width=0) (actual time=2.005..2.006 rows=58383 loops=1)   |
                                      Index Cond: ((status)::text = 'paid'::text)                                                                           |
                          ->  Hash  (cost=32.19..32.19 rows=465 width=8) (actual time=0.271..0.272 rows=696 loops=1)                                        |
                                Buckets: 1024  Batches: 1  Memory Usage: 36kB                                                                               |
                                ->  Bitmap Heap Scan on seances s  (cost=11.89..32.19 rows=465 width=8) (actual time=0.038..0.157 rows=696 loops=1)         |
                                      Recheck Cond: ((start_at)::date > (CURRENT_DATE - '7 days'::interval))                                                |
                                      Heap Blocks: exact=11                                                                                                 |
                                      ->  Bitmap Index Scan on start_at_idx  (cost=0.00..11.77 rows=465 width=0) (actual time=0.028..0.029 rows=696 loops=1)|
                                            Index Cond: ((start_at)::date > (CURRENT_DATE - '7 days'::interval))                                            |
                    ->  Hash  (cost=10.30..10.30 rows=30 width=520) (actual time=0.013..0.014 rows=9 loops=1)                                               |
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                      |
                          ->  Seq Scan on films f  (cost=0.00..10.30 rows=30 width=520) (actual time=0.006..0.009 rows=9 loops=1)                           |
Planning Time: 0.341 ms                                                                                                                                     |
Execution Time: 40.749 ms                                                                                                                                   |

используются индексы на tickets.status и sessiosns.start_at + смена типа данных для start_at


select f.title, sum(t.price) from tickets t
join seances s on t.seance_id = s.id
join films f on f.id = s.film_id 
where status = 'paid'
and s.start_at > current_date - interval '1 week'
group by f.title 
order by sum desc
limit 3


QUERY PLAN                                                                                                                                               |
---------------------------------------------------------------------------------------------------------------------------------------------------------+
Limit  (cost=3496.37..3496.38 rows=3 width=548) (actual time=32.234..32.239 rows=3 loops=1)                                                              |
  ->  Sort  (cost=3496.37..3496.44 rows=30 width=548) (actual time=32.233..32.237 rows=3 loops=1)                                                        |
        Sort Key: (sum(t.price)) DESC                                                                                                                    |
        Sort Method: quicksort  Memory: 25kB                                                                                                             |
        ->  HashAggregate  (cost=3495.61..3495.98 rows=30 width=548) (actual time=32.219..32.225 rows=5 loops=1)                                         |
              Group Key: f.title                                                                                                                         |
              Batches: 1  Memory Usage: 24kB                                                                                                             |
              ->  Hash Join  (cost=708.86..3375.01 rows=24119 width=521) (actual time=2.815..25.528 rows=23981 loops=1)                                  |
                    Hash Cond: (s.film_id = f.id)                                                                                                        |
                    ->  Hash Join  (cost=698.19..3292.08 rows=24119 width=9) (actual time=2.796..21.141 rows=23981 loops=1)                              |
                          Hash Cond: (t.seance_id = s.id)                                                                                                |
                          ->  Bitmap Heap Scan on tickets t  (cost=655.55..3096.17 rows=58210 width=9) (actual time=1.900..11.475 rows=58383 loops=1)    |
                                Recheck Cond: ((status)::text = 'paid'::text)                                                                            |
                                Heap Blocks: exact=1713                                                                                                  |
                                ->  Bitmap Index Scan on status_idx  (cost=0.00..641.00 rows=58210 width=0) (actual time=1.721..1.721 rows=58383 loops=1)|
                                      Index Cond: ((status)::text = 'paid'::text)                                                                        |
                          ->  Hash  (cost=35.41..35.41 rows=578 width=8) (actual time=0.465..0.466 rows=573 loops=1)                                     |
                                Buckets: 1024  Batches: 1  Memory Usage: 31kB                                                                            |
                                ->  Seq Scan on seances s  (cost=0.00..35.41 rows=578 width=8) (actual time=0.016..0.363 rows=573 loops=1)               |
                                      Filter: (start_at > (CURRENT_DATE - '7 days'::interval))                                                           |
                                      Rows Removed by Filter: 822                                                                                        |
                    ->  Hash  (cost=10.30..10.30 rows=30 width=520) (actual time=0.014..0.014 rows=9 loops=1)                                            |
                          Buckets: 1024  Batches: 1  Memory Usage: 9kB                                                                                   |
                          ->  Seq Scan on films f  (cost=0.00..10.30 rows=30 width=520) (actual time=0.007..0.009 rows=9 loops=1)                        |
Planning Time: 0.358 ms                                                                                                                                  |
Execution Time: 32.313 ms                                                                                                                                |