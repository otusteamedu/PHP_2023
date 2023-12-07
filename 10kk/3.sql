--Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN ANALYSE
SELECT m.name       as "Film name",
       s.start_time as "Datetime",
       h.name       as "Hall name"
FROM showtime as s
         LEFT JOIN movies m ON s.movie_id = m.id
         LEFT JOIN halls h ON s.hall_id = h.id
WHERE s.start_time BETWEEN (concat(CURRENT_DATE, ' 00:00:00'))::timestamp AND (concat(CURRENT_DATE, ' 23:59:59'))::timestamp;

-- Hash Left Join  (cost=56.90..57.68 rows=21 width=551) (actual time=0.859..0.867 rows=20 loops=1)
--   Hash Cond: (s.hall_id = h.id)
--   ->  Merge Right Join  (cost=43.75..44.47 rows=21 width=39) (actual time=0.795..0.800 rows=20 loops=1)
--         Merge Cond: (m.id = s.movie_id)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..3410.29 rows=100000 width=31) (actual time=0.019..0.022 rows=11 loops=1)
--         ->  Sort  (cost=43.46..43.51 rows=21 width=16) (actual time=0.769..0.770 rows=20 loops=1)
--               Sort Key: s.movie_id
--               Sort Method: quicksort  Memory: 26kB
--               ->  Seq Scan on showtime s  (cost=0.00..43.00 rows=21 width=16) (actual time=0.039..0.730 rows=20 loops=1)
-- "                    Filter: ((start_time >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                     Rows Removed by Filter: 980
--   ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.018..0.018 rows=10 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=0.007..0.007 rows=10 loops=1)
-- Planning Time: 11.263 ms
-- Execution Time: 1.004 ms

create index idx_sessions_datetime on showtime (start_time);

-- Hash Left Join  (cost=27.15..27.92 rows=21 width=551) (actual time=3.723..3.742 rows=20 loops=1)
--   Hash Cond: (s.hall_id = h.id)
--   ->  Merge Right Join  (cost=14.00..14.72 rows=21 width=39) (actual time=3.386..3.399 rows=20 loops=1)
--         Merge Cond: (m.id = s.movie_id)
--         ->  Index Scan using movies_pkey on movies m  (cost=0.29..3410.29 rows=100000 width=31) (actual time=0.030..0.037 rows=11 loops=1)
--         ->  Sort  (cost=13.71..13.76 rows=21 width=16) (actual time=3.341..3.343 rows=20 loops=1)
--               Sort Key: s.movie_id
--               Sort Method: quicksort  Memory: 26kB
--               ->  Bitmap Heap Scan on showtime s  (cost=4.51..13.25 rows=21 width=16) (actual time=3.209..3.253 rows=20 loops=1)
-- "                    Recheck Cond: ((start_time >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                     Heap Blocks: exact=7
--                     ->  Bitmap Index Scan on idx_sessions_datetime  (cost=0.00..4.50 rows=21 width=0) (actual time=3.179..3.179 rows=20 loops=1)
-- "                          Index Cond: ((start_time >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--   ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.090..0.091 rows=10 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=0.060..0.062 rows=10 loops=1)
-- Planning Time: 5.390 ms
-- Execution Time: 3.961 ms
