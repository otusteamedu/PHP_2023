EXPLAIN ANALYZE
SELECT a.seance_id, c.name, b.date, b.time, sum(a.price) as seance_profit
FROM seance_tikets a
JOIN seances b ON b.id=a.seance_id
JOIN films c ON c.id=b.film_id
WHERE b.date>='2023-12-01' and b.date<='2023-12-07'
GROUP BY a.seance_id, c.name, b.date, b.time
ORDER BY seance_profit
DESC LIMIT 3

/*
Limit  (cost=35735.60..35735.61 rows=3 width=564) (actual time=93.404..93.461 rows=3 loops=1)
  ->  Sort  (cost=35735.60..36062.02 rows=130567 width=564) (actual time=93.403..93.459 rows=3 loops=1)
        Sort Key: (sum(a.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  Finalize GroupAggregate  (cost=16422.56..34048.05 rows=130567 width=564) (actual time=31.417..92.476 rows=6004 loops=1)
              Group Key: a.seance_id, c.name, b.date, b."time"
              ->  Gather Merge  (cost=16422.56..31263.90 rows=76804 width=564) (actual time=31.375..89.016 rows=6536 loops=1)
                    Workers Planned: 1
                    Workers Launched: 1
                    ->  Partial GroupAggregate  (cost=15422.55..21623.44 rows=76804 width=564) (actual time=25.114..71.126 rows=3268 loops=2)
                          Group Key: a.seance_id, c.name, b.date, b."time"
                          ->  Incremental Sort  (cost=15422.55..19703.34 rows=76804 width=537) (actual time=25.095..60.262 rows=65227 loops=2)
                                Sort Key: a.seance_id, c.name, b.date, b."time"
                                Presorted Key: a.seance_id
                                Full-sort Groups: 1736  Sort Method: quicksort  Average Memory: 29kB  Peak Memory: 29kB
                                Pre-sorted Groups: 55  Sort Method: quicksort  Average Memory: 26kB  Peak Memory: 26kB
                                Worker 0:  Full-sort Groups: 1289  Sort Method: quicksort  Average Memory: 27kB  Peak Memory: 27kB
                                  Pre-sorted Groups: 29  Sort Method: quicksort  Average Memory: 26kB  Peak Memory: 26kB
                                ->  Merge Join  (cost=15422.02..17211.10 rows=76804 width=537) (actual time=25.032..45.592 rows=65227 loops=2)
                                      Merge Cond: (a.seance_id = b.id)
                                      ->  Sort  (cost=14781.77..15101.57 rows=127922 width=9) (actual time=22.505..28.732 rows=108734 loops=2)
                                            Sort Key: a.seance_id
                                            Sort Method: external merge  Disk: 2408kB
                                            Worker 0:  Sort Method: external merge  Disk: 1768kB
                                            ->  Parallel Seq Scan on seance_tikets a  (cost=0.00..2665.22 rows=127922 width=9) (actual time=0.051..8.146 rows=108734 loops=2)
                                      ->  Sort  (cost=640.19..655.20 rows=6004 width=532) (actual time=2.501..4.764 rows=67952 loops=2)
                                            Sort Key: b.id
                                            Sort Method: quicksort  Memory: 567kB
                                            Worker 0:  Sort Method: quicksort  Memory: 567kB
                                            ->  Hash Join  (cost=13.15..263.39 rows=6004 width=532) (actual time=0.096..1.593 rows=6004 loops=2)
                                                  Hash Cond: (b.film_id = c.id)
                                                  ->  Seq Scan on seances b  (cost=0.00..234.00 rows=6004 width=20) (actual time=0.019..0.767 rows=6004 loops=2)
                                                        Filter: ((date >= '2023-12-01'::date) AND (date <= '2023-12-07'::date))
                                                        Rows Removed by Filter: 3996
                                                  ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.048..0.049 rows=13 loops=2)
                                                        Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                                        ->  Seq Scan on films c  (cost=0.00..11.40 rows=140 width=520) (actual time=0.041..0.042 rows=13 loops=2)
Planning Time: 0.152 ms
Execution Time: 93.914 ms
*/


--добавляем индексы
CREATE INDEX seances_date_id_idx ON seances(date);
CREATE INDEX seances_hall_id_idx ON seances(hall_id);
CREATE INDEX seances_film_id_idx ON seances(film_id);


/*
Limit  (cost=16762.91..16762.92 rows=3 width=564) (actual time=94.836..94.838 rows=3 loops=1)
  ->  Sort  (cost=16762.91..17089.33 rows=130567 width=564) (actual time=94.835..94.836 rows=3 loops=1)
        Sort Key: (sum(a.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  GroupAggregate  (cost=2.41..15075.36 rows=130567 width=564) (actual time=0.085..93.718 rows=6004 loops=1)
              Group Key: a.seance_id, c.name, b.date, b."time"
              ->  Incremental Sort  (cost=2.41..11811.18 rows=130567 width=537) (actual time=0.063..73.740 rows=130454 loops=1)
                    Sort Key: a.seance_id, c.name, b.date, b."time"
                    Presorted Key: a.seance_id
                    Full-sort Groups: 2990  Sort Method: quicksort  Average Memory: 29kB  Peak Memory: 29kB
                    Pre-sorted Groups: 93  Sort Method: quicksort  Average Memory: 26kB  Peak Memory: 26kB
                    ->  Merge Join  (cost=0.74..7158.65 rows=130567 width=537) (actual time=0.025..43.784 rows=130454 loops=1)
                          Merge Cond: (b.id = a.seance_id)
                          ->  Nested Loop  (cost=0.44..465.95 rows=6004 width=532) (actual time=0.016..3.516 rows=6004 loops=1)
                                ->  Index Scan using seances_pkey on seances b  (cost=0.29..315.84 rows=6004 width=20) (actual time=0.007..1.466 rows=6004 loops=1)
                                      Filter: ((date >= '2023-12-01'::date) AND (date <= '2023-12-07'::date))
                                      Rows Removed by Filter: 3996
                                ->  Memoize  (cost=0.15..0.17 rows=1 width=520) (actual time=0.000..0.000 rows=1 loops=6004)
                                      Cache Key: b.film_id
                                      Cache Mode: logical
                                      Hits: 6001  Misses: 3  Evictions: 0  Overflows: 0  Memory Usage: 1kB
                                      ->  Index Scan using films_pkey on films c  (cost=0.14..0.16 rows=1 width=520) (actual time=0.002..0.002 rows=1 loops=3)
                                            Index Cond: (id = b.film_id)
                          ->  Index Scan using seance_tikets_seance_id_idx on seance_tikets a  (cost=0.29..4868.85 rows=217467 width=9) (actual time=0.004..22.280 rows=217467 loops=1)
Planning Time: 0.615 ms
Execution Time: 94.891 ms
*/