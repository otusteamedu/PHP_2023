--Формирование афиши (фильмы, которые показывают сегодня)
EXPLAIN
ANALYSE
SELECT m.name       as "Film name",
       s.start_time as "Datetime",
       h.name       as "Hall name"
FROM showtime as s
         LEFT JOIN movies m ON s.movie_id = m.id
         LEFT JOIN halls h ON s.hall_id = h.id
WHERE s.start_time BETWEEN (concat(CURRENT_DATE, ' 00:00:00'))::timestamp
  AND (concat(CURRENT_DATE, ' 23:59:59'))::timestamp;
-- Hash Left Join  (cost=13.43..132.00 rows=7 width=1040) (actual time=0.103..0.196 rows=1 loops=1)
--   Hash Cond: (s.hall_id = h.id)
--   ->  Nested Loop Left Join  (cost=0.28..118.83 rows=7 width=528) (actual time=0.063..0.154 rows=1 loops=1)
--         ->  Seq Scan on showtime s  (cost=0.00..60.75 rows=7 width=16) (actual time=0.042..0.133 rows=1 loops=1)
-- "              Filter: ((start_time >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--               Rows Removed by Filter: 99
--         ->  Index Scan using movies_pkey on movies m  (cost=0.28..8.29 rows=1 width=520) (actual time=0.018..0.018 rows=1 loops=1)
--               Index Cond: (id = s.movie_id)
--   ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.025..0.026 rows=10 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=0.008..0.009 rows=10 loops=1)
-- Planning Time: 3.183 ms
-- Execution Time: 0.313 ms

create index idx_sessions_datetime on showtime (start_time);
-- Hash Right Join  (cost=5.23..17.35 rows=2 width=551) (actual time=0.223..0.230 rows=1 loops=1)
--   Hash Cond: (h.id = s.hall_id)
--   ->  Seq Scan on halls h  (cost=0.00..11.40 rows=140 width=520) (actual time=0.004..0.005 rows=10 loops=1)
--   ->  Hash  (cost=5.20..5.20 rows=2 width=39) (actual time=0.206..0.207 rows=1 loops=1)
--         Buckets: 1024  Batches: 1  Memory Usage: 9kB
--         ->  Merge Right Join  (cost=4.79..5.20 rows=2 width=39) (actual time=0.191..0.193 rows=1 loops=1)
--               Merge Cond: (m.id = s.movie_id)
--               ->  Index Scan using movies_pkey on movies m  (cost=0.29..354.29 rows=10000 width=31) (actual time=0.020..0.022 rows=11 loops=1)
--               ->  Sort  (cost=4.51..4.51 rows=2 width=16) (actual time=0.163..0.163 rows=1 loops=1)
--                     Sort Key: s.movie_id
--                     Sort Method: quicksort  Memory: 25kB
--                     ->  Seq Scan on showtime s  (cost=0.00..4.50 rows=2 width=16) (actual time=0.050..0.139 rows=1 loops=1)
-- "                          Filter: ((start_time >= (concat(CURRENT_DATE, ' 00:00:00'))::timestamp without time zone) AND (start_time <= (concat(CURRENT_DATE, ' 23:59:59'))::timestamp without time zone))"
--                           Rows Removed by Filter: 99
-- Planning Time: 2.990 ms
-- Execution Time: 0.292 ms